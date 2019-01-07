The ProAbono PHP Client Library is an open source library to interact with ProAbono’s subscription management from your PHP website. This library interacts with the ProAbono Live API.


 ###Requirements:

The website works with dependencies available with Composer.
You need PHP >=5.6.0. 

Composer
If you're using Composer, you can simply add a dependency on proabono/proabono-php to your project's composer.json file.

```
{
    “require”: {
        “proabono/proabono-php”: “dev-master”    
    }
}
```

 ###ProAbono - Settings

In the ProAbono backoffice, open the top right menu by clicking your name, then select Integration.
Note the 4 values : keyAgent, keyApi, endpoint, public pricing url.

In the config.php file, you need to set the 4 ProAbono Settings :
- keyAgent (ex: ce0d53ed-19b6-423c-bf0f-2076e4886758 )
- keyApi (ex: 83d47ce5-ae32-4895-82e1-151cb7297914 )
- endpoint (ex: https://api-42.proabono.com )
- public pricing url (ex: https://demo-php-eur.proabono.com/pricing )


 ###How to use the library

Read the ProAbono API documentation for more information about the API.

There is a demo project using this library available here :
https://github.com/kserbouty/proabono-php-demo
