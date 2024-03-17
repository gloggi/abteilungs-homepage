# Gloggi Abteilungs-Homepage

Unsere Webapp ist speziell darauf ausgerichtet, Webseiten für Abteilungen und Pfadiregionen zu erstellen. Sie bietet eine flexible und modulare Plattform, mit der Benutzer ihre eigenen Seiten aus verschiedenen Bausteinen zusammenstellen können. Die Webapp hat folgende Funktionen:

- **Modulare Webseitenerstellung:** Gestalte die Webseite deiner Abteilung mit einer Vielzahl von Modulen, darunter Bilder-Banner, Formulare und spezielle Pfadimodule.
- **Gruppenseiten:** Einheitsleitende haben Zugang zu ihrer Gruppenseite, welche speziell auf ihre Gruppe zugeschnitten ist.
- **Veranstaltungsmanagement:** Erfasse Samstagnachmittagsevents, die auf den Gruppenseiten dargestellt werden.
- **MiData OAuth Login:** Der Zugang zum Editorbereich wird durch die OAuth-Funktion der MiData ermöglicht.

## Development

1. Klone das GIT-Repository:

```
git clone https://github.com/gloggi/abteilungs-homepage.git
```

2. Wechsle in das Directory:

```
cd abteilungs-homepage
```

3. Starte die Docker-Container:

```
docker-compose up -d
```

4. Das Frontend der Webseite findest du unter ```http://localhost:8080``` und das Backend unter ```http://localhost:8000```

### Login
Das Login zum Editorenbereich unter ```http://localhost:8080/dashboard``` funktioniert mithilfe der Testumgebung der MiData gehosted unter ```https://pbs.puzzle.ch```. Damit das Login zusammen mit den Seeds funktioniert, kannst du dich mit folgenden Accounts einloggen:

| Abteilungsleitung |                    |
|-------------------|--------------------|
| E-Mail            | rissi@gloggi.ch    |
| Passwort          | Rissi@Lagom1234    |

| Einheitsleitung   |                    |
|-------------------|--------------------|
| E-Mail            | diff@gloggi.ch     |
| Passwort          | Diff@Lagom1234     |

| Webmaster         |                      |
|-------------------|----------------------|
| E-Mail            | satoshi@gloggi.ch    |
| Passwort          | Satoshi@Lagom1234    |


## Deployment

Jede Nacht wird der Stand vom master Branch auf alle deploy-* Branches [synchronisiert](https://github.com/gloggi/abteilungs-homepage/blob/master/.github/workflows/nightly.yml). Bei einem Push auf einen deploy-* Branch läuft ein [CI/CD-Job](https://github.com/gloggi/abteilungs-homepage/blob/master/.github/workflows/ci-cd.yml) welcher via ein [Skript](https://github.com/gloggi/abteilungs-homepage/blob/master/.github/actions/deploy/deploy.sh) die Applikation buildet und per SFTP auf den Server hochlädt. Pro deploy-* Branch haben wir daher eigene Secrets und Variables in den GitHub Environments dieses Repositories angelegt. Diese Secrets und Variables bestimmen, wohin und mit welchen Einstellungen der Code deployed wird.

### Neues Deployment einrichten
In diesem Beispiel legen wir ein Deployment für die Abteilung Lagom unter der Adresse https://lagom.ch an.
1. Auf dem Hosting zwei (Sub-)Domains anlegen:
    * lagom.ch -> hierhin wird das Vue.js Frontend deployed, daher z.B. auf einen Ordner ~/www/lagom.ch im Hosting zeigen lassen
    * api.lagom.ch -> hierhin wird das Laravel Backend deployed, daher z.B. das Verzeichnis ~/www/lagom.ch-api anlegen, und den Webroot dieser Subdomain auf ~/www/lagom.ch-api/public zeigen lassen
2. Auf dem Hosting eine neue Datenbank mit einem neuen User anlegen. Dabei Datenbank-Host, Datenbankname, Username und Passwort notieren
3. MiData OAuth Applikation einrichten
    * Für Testumgebungen unter https://pbs.puzzle.ch auf Einstellungen -> OAuth Apps gehen
    * Für produktive Umgebungen das Antragsformular verwenden welches unter https://pfadi.swiss/media/files/1c/schnittstellen_2021_de.pdf verlinkt ist
    * Callback URL: https://lagom.ch/login
    * Benötigte Scopes: email, name, with_roles
4. Im GitHub Webinterface auf diesem Repository unter Settings -> Environments ein neues Environment namens lagom anlegen
5. Im GitHub Environment lagom folgende Environment secrets erfassen:
    * `APP_KEY`: Kann man lokal generieren indem man `docker compose run --rm --entrypoint php artisan key:generate` ausführt und den generierten APP_KEY aus api/.env holt
    * `DB_HOST`: Aus den Datenbank-Credentials vom DB erstellen (siehe oben)
    * `DB_DATABASE`: Aus den Datenbank-Credentials vom DB erstellen (siehe oben)
    * `DB_USERNAME`: Aus den Datenbank-Credentials vom DB erstellen (siehe oben)
    * `DB_PASSWORD`: Aus den Datenbank-Credentials vom DB erstellen (siehe oben)
    * `MIDATA_CLIENT_SECRET`: Von der MiData-OAuth-App (siehe oben)
    * `SSH_PRIVATE_KEY`: Kann man lokal generieren mit `ssh-keygen -t rsa`, dann den Inhalt von id_rsa.pub auf dem Hosting als erlaubten SSH-Key eintragen, und den Inhalt von id_rsa ins GitHub Secret eintragen
    * `SSH_USERNAME`: Accountname für SSH-Login beim Hosting
    * `MAIL_USERNAME`: E-Mail Benutzername
    * `MAIL_PASSWORD`: E-Mail Passwort
6. Im GitHub Environment lagom folgende Environment variables erfassen:
    * `APP_NAME`: Name der Pfadiabteilung, wird aktuell nur für den Namen der Session Cookies verwendet
    * `BACKEND_URL`: URL zum Backend https://api.lagom.ch
    * `FRONTEND_URL`: URL zum Frontend https://lagom.ch
    * `MIDATA_BASE_URL`: https://pbs.puzzle.ch für Testumgebungen, https://db.scout.ch für produktive Umgebungen
    * `MIDATA_CLIENT_UID`: Von der MiData-OAuth-App (siehe oben)
    * `MIDATA_ID`: Die ID von der Abteilung auf MiData (https://db.scout.ch/de/groups/{ID})
    * `SEED_DB`: Auf den Wert `true` setzen falls die Inhalte dieser Umgebung bei jedem Deployment mit den Seeds überschrieben werden sollen. Ansonsten weglassen.
    * `SSH_BACKEND_DIRECTORY`: Pfad auf dem Server wo das Backend hochgeladen werden soll. In unserem Beispiel ~/www/lagom.ch-api
    * `SSH_FRONTEND_DIRECTORY`: Pfad auf dem Server wo das Frontend hochgeladen werden soll. In unserem Beispiel ~/www/lagom.ch
    * `SSH_HOST`: Hostname des Hostings für den SSH Login
    * `SSH_PORT`: Port für den SSH-Zugriff auf den Server (default 22)
    * `SSH_KNOWN_HOSTS`: Kann lokal herausgesucht werden, indem man ~/.ssh/known_hosts temporär umbenennt und dann eine SSH-Verbindung von lokal zum Hosting aufmacht. Der Inhalt des neuen ~/.ssh/known_hosts gehört in diese Variable. Die alte Kopie wiederherstellen nicht vergessen!
    * `MAIL_MAILER`: Email-System, das verwendet wird (z.B. smtp, sendmail, mailgun, etc.)
    * `MAIL_HOST`: Hostname des Email-Servers
    * `MAIL_PORT`: Port für die Email-Kommunikation
    * `MAIL_ENCRYPTION`: Verschlüsselungsmethode für Emails (z.B. tls, ssl, none)
    * `MAIL_FROM_ADDRESS`: Standard-Absenderadresse für ausgehende Emails
    * `MAIL_FROM_NAME`: Standard-Absendername für ausgehende Emails
7. In [nightly.yml](https://github.com/gloggi/abteilungs-homepage/blob/master/.github/workflows/nightly.yml) einen Punkt `- uses: repo-sync/github-sync@v2` inkl. Unterpunkten kopieren und destination-branch auf `deploy-lagom` anpassen (muss mit `deploy-` anfangen und `lagom` muss ganz genau gleich geschrieben sein wie das GitHub Environment heisst)
8. Code von master auf den neuen Branch deploy-lagom pushen und in GitHub Actions zuschauen wie das Deployment zum ersten Mal läuft