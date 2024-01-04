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

| Poweruser         |                      |
|-------------------|----------------------|
| E-Mail            | satoshi@gloggi.ch    |
| Passwort          | Satoshi@Lagom1234    |

Um den Testaccount des Powerusers zu nutzen, ist ein Login mit der 2-Faktor-Authentifizierung (2FA) erforderlich. Scanne dazu den bereitgestellten QR-Code mit einer Authenticator-App deiner Wahl.

<img src="https://github.com/gloggi/abteilungs-homepage/blob/master/satoshi_2FA.jpg?raw=true" height="200px" width="200px" />

