# OAuth Signin
 
The following is an example of how to config these classes using json with Dice.

```json
{
    "$office365Provider" : {
        "instanceOf" : "League\\OAuth2\\Client\\Provider\\GenericProvider",
        "constructParams" : [{
            "clientId"                : "your client id",
            "clientSecret"            : "your client secret",
            "redirectUri"             : "your redirect uri",
            "urlAuthorize"            : "https://login.microsoftonline.com/common/oauth2/v2.0/authorize",
            "urlAccessToken"          : "https://login.microsoftonline.com/common/oauth2/v2.0/token",
            "urlResourceOwnerDetails" : "",
            "scopes"                  : "openid YourScopes"
        }]
    },
    "Solleer\\OAuthSignin\\SigninHandler\\Office365Auth" : {
        "constructParams" : [
            { "Dice::INSTANCE": "$office365Provider"}
        ]
    },
    "Google_Client" : {
        "instanceOf" : "Solleer\\OAuthSignin\\SigninHandler\\GoogleClientFactory",
        "call" : [
            ["createWithToken", [], "Dice::CHAIN_CALL"],
            ["setAuthConfig", ["Your Google Config Json file"]],
            ["setRedirectUri", ["your redirect uri"]],
            ["addScope", [[
                { "Dice::CONSTANT" :  "Google_Service_Oauth2::USERINFO_EMAIL" },
                "Your Scopes"
            ]]]
        ],
        "shared" : true
    }
}
```