## LibreMonkey - create forms without spyware

[![License](https://img.shields.io/github/license/golddominik893/libremonkey?label=License&color=brightgreen&cacheSeconds=3600)](./LICENSE)
[![Release](https://img.shields.io/github/v/release/golddominik893/libremonkey?label=Release&color=brightgreen&cacheSeconds=3600)](https://github.com/golddominik893/libremonkey/releases/latest)
[![Commits](https://img.shields.io/github/commit-activity/y/golddominik893/libremonkey?color=red&label=commits)](https://github.com/golddominik893/libremonkey/commits)
[![Issues](https://img.shields.io/github/issues/golddominik893/libremonkey?color=important)](https://github.com/golddominik893/libremonkey/issues)
[![Pull Requests](https://img.shields.io/github/issues-pr/golddominik893/libremonkey?color=blueviolet)](https://github.com/golddominik893/libremonkey/pulls)

> [!CAUTION]
> It is strongly not recommended to deploy this software for production as there may be SQL injection vulnerabilities and there may also be a few other security vulnerabilities such as editing the fields in a form when you are not even logged in.

### Features

- Create Surveys
  - view responses
  - users can also view all their responses
  - **in a future update form owners can get averages for user responses or analytics.*
- No third party advertisements or data monetisation.
- It's Free Open Source Software, the free use is dependant on the instance operator.

### To do

- radio buttons
- checkboxes
- user settings
  - theme settings
  - password change
  - delete account
- anonymous responses
- email verification option in surveys
- dropdowns
- allow users to remove responses
- analytics for number based surveys
- survey customisation
  - themes
  - quiz mode

### Advantages of LibreMonkey

|                   | LibreMonkey       | SurveyMonkey(free)                           | Microsoft Forms(free)                            | Google Forms(free)                             |
|-------------------|-------------------|----------------------------------------------|--------------------------------------------------|------------------------------------------------|
| **Question Limit** | No limit          | 10                                           | 200                                              | Unlimited                                      |
| **Survey Limit**   | No limit          | 200                                          | Max 5GB                                          | Max 15GB                                       |
| **Responses Limit**| No limit          | 100                                          | Max 5GB                                          | Max 15GB                                       |
| **Question Types** | 12                | Limited                                      | A few                                            | Many                                           |
| **Privacy**        | No data collected or sold | [Privacy](https://www.surveymonkey.com/mp/legal/privacy/) | [Privacy](https://support.microsoft.com/en-us/office/security-and-privacy-in-microsoft-forms-7e57f9ba-4aeb-4b1b-9e21-b75318532cd9) | [Privacy](https://policies.google.com/privacy) |
| **Speed**          | Very fast          | Fast                                         | Fast                                             | Fastest                                        |

### How it works

LibreMonkey uses the PHP backend alongside MySQL to store surveys and survey responses. LibreMonkey is the clear winner when in comparison to all the others because it is fast and does not sell your data.

### Screenshots (current stage)

| Home Page | Client Area |
|---|---|
| ![Home Page image](screenshots/home-page.jpg) | ![Client Area image](screenshots/client-area.jpg) |

| Form Creation | Form Editing |
|---|---|
| ![Form Creation image](screenshots/form-creation.jpg) | ![Form Editing image](screenshots/form-editing.jpg) |

| User Response | Login Page |
|---|---|
| ![User Response image](screenshots/user-response.jpg) | ![Login Page image](screenshots/login.jpg) |

> [!NOTE]
> This software is still under development and may not work as intended.

### Prerequisites

- A web server like Apache or Nginx
- PHP interpreter
- SQL database like MySQL
- phpMyAdmin (OPTIONAL)

### Installation

Clone the git repository

```bash
git clone https://github.com/GoldDominik893/libremonkey.git
cd libremonkey/
```

Move the contents of the libremonkey/ folder to the website root directory

```bash
mv * /var/www/html
```

Now Libremonkey will be accessible at `127.0.0.1:80`, but it requires an SQL database to operate.

The easiest way to import the database.sql file would be by using a WebGUI with phpMyAdmin, but you can do it by any other means.

Edit the `config.php` file to adjust the database credentials.

```bash
nano /var/www/html/config.php
```

### License

Libremonkey is licensed under the MIT License. 
Copyright (c) Dominik Wajda 2025

#### Liability

We take no responsibility for the use of our tool, or external instances
provided by third parties. We strongly recommend you abide by the valid
official regulations in your country. Furthermore, we refuse liability
for any inappropriate use of Libremonkey, such as illegal data collection.
This tool is provided to you in the spirit of free, open software.

You may view the LICENSE in which this software is provided to you [here](./LICENSE).

> THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
