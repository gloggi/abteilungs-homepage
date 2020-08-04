<?php

use Directus\Application\Http\Request;
use Directus\Application\Http\Response;
use Directus\Services\ItemsService;
use Directus\Services\MailService;
use Directus\Permissions\Acl;
use Directus\Services\TablesService;


return [
    // See documentation at https://docs.directus.io/extensions/custom-endpoints.html#creating-custom-endpoints

    // The endpoints in this file are available under http://localhost:8080/_/custom/form

    // The endpoint path:
    // '' means it is located at: `/custom/<endpoint-id>`
    // '/` means it is located at: `/custom/<endpoint-id>/`
    // 'test' and `/test` means it is located at: `/custom/<endpoint-id>/test
    // if the handler is a Closure or Anonymous function, it's binded to the app container. Which means $this = to the app container.
    '' => [
        'method' => 'POST',
        'handler' => function (Request $request, Response $response) {
            // Get submitted form data
            $data = $request->getParsedBody();
            $use_recaptcha = $data["useRecaptcha"];
            $response_key = $data["responseKey"];
            $form_fields = $data["formFields"];
            $form_title = $data["formTitle"];
            $form_email = $data["formEmail"];
            $output = "";
            for ($i = 0; $i < count($form_fields); $i++) {
                if($form_fields[$i]["type"]=="date"){
                    $date =explode("-",$form_fields[$i]["answer"]);
                    $form_fields[$i]["answer"] = $date[2].".".$date[1].".".$date[0];
                }
                if($form_fields[$i]["type"]=="gender"){
                    if($form_fields[$i]["answer"]=="f"){
                        $form_fields[$i]["answer"]="weiblich";
                    }elseif ($form_fields[$i]["answer"]=="m"){
                        $form_fields[$i]["answer"]="männlich";
                    }else{
                        $form_fields[$i]["answer"]="sonstiges";
                    }
                }
                if($form_fields[$i]["answer"]==""){
                    $form_fields[$i]["answer"]="-";
                }
                $output = $output .
                    "<br><b>" . $form_fields[$i]["name"] . "</b>:<br> " .
                    $form_fields[$i]["answer"] . "<br>";

            }
            // Get all answers from DB
            $container = \Directus\Application\Application::getInstance()->getContainer();
            $dbConnection = $container->get('database');

            $tableGateway = Directus\Database\TableGatewayFactory::create('settings', [
                // An Zend\Db\Adapter\Adapter instance
                'connection' => $dbConnection,
                // options are:
                //  false = no acl validation
                //  null = uses $container->get('acl')
                //  an Directus\Permissions\Acl instance
                'acl' => false
            ]);
            $settings = $tableGateway->getItems()["data"][0];
            if($use_recaptcha){
            $recaptcha_secret_key = $settings["recaptcha_secret_key"];
            # Verify captcha
            $post_data = http_build_query(
                array(
                    'secret' => $recaptcha_secret_key,
                    'response' => $response_key,
                    'remoteip' => $_SERVER['REMOTE_ADDR']
                )
            );
            $opts = array('http' =>
                array(
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $post_data
                )
            );
            $context = stream_context_create($opts);
            $answer = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
            $result = json_decode($answer);
            $success = $result->success;
            }else{
                $success=true;
            }
            if($success){
            // Set UserEmail and UserFullName for E-Mail delivery
            $acl = $container->get('acl');
            $acl->setUserEmail($container->get('config')->get('mail.default.from'));
            $acl->setUserFullName($settings["website_title"]);

            // Send E-Mail
                        $mail = new MailService($container);
                        $mail->send([
                            "to" =>
                                $form_email
                            ,
                            "subject" => "Nachricht von: " . $form_title,
                            "body" => "<h1>" . "Nachricht von: " . $form_title . "</h1>" . $output,
                            "type" => "html",
                        ]);

            }

            return $response->withJson([
                'data' => [
                    "success"=>$success,

                ]
            ]);
        }
    ]
];
