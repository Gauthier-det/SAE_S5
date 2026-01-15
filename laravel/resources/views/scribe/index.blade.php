<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Laravel API Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "http://localhost";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.6.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.6.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-endpoints" class="tocify-header">
                <li class="tocify-item level-1" data-unique="endpoints">
                    <a href="#endpoints">Endpoints</a>
                </li>
                                    <ul id="tocify-subheader-endpoints" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="endpoints-GETapi-reset">
                                <a href="#endpoints-GETapi-reset">Reset the database and seed it with initial data
This endpoint is for development purposes only</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-login">
                                <a href="#endpoints-POSTapi-login">POST api/login</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-logout">
                                <a href="#endpoints-POSTapi-logout">POST api/logout</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-register">
                                <a href="#endpoints-POSTapi-register">POST api/register</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-raids">
                                <a href="#endpoints-GETapi-raids">GET api/raids</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-raids--id-">
                                <a href="#endpoints-GETapi-raids--id-">GET api/raids/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-raids--raidId--races">
                                <a href="#endpoints-GETapi-raids--raidId--races">GET api/raids/{raidId}/races</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-races">
                                <a href="#endpoints-GETapi-races">GET api/races</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-races--id-">
                                <a href="#endpoints-GETapi-races--id-">GET api/races/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-races--id--details">
                                <a href="#endpoints-GETapi-races--id--details">GET api/races/{id}/details</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-races--raceId--results">
                                <a href="#endpoints-GETapi-races--raceId--results">GET api/races/{raceId}/results</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-races--raceId--prices">
                                <a href="#endpoints-GETapi-races--raceId--prices">GET api/races/{raceId}/prices</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-clubs">
                                <a href="#endpoints-GETapi-clubs">GET api/clubs</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-clubs--id-">
                                <a href="#endpoints-GETapi-clubs--id-">GET api/clubs/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-clubs--clubId--users">
                                <a href="#endpoints-GETapi-clubs--clubId--users">GET api/clubs/{clubId}/users</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-users-free">
                                <a href="#endpoints-GETapi-users-free">GET api/users/free</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-raids">
                                <a href="#endpoints-POSTapi-raids">POST api/raids</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-PUTapi-raids--id-">
                                <a href="#endpoints-PUTapi-raids--id-">PUT api/raids/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-DELETEapi-raids--id-">
                                <a href="#endpoints-DELETEapi-raids--id-">DELETE api/raids/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-races">
                                <a href="#endpoints-POSTapi-races">POST api/races</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-races-with-prices">
                                <a href="#endpoints-POSTapi-races-with-prices">POST api/races/with-prices</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-races--raceId--team-results">
                                <a href="#endpoints-POSTapi-races--raceId--team-results">POST api/races/{raceId}/team-results</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-PUTapi-races--id-">
                                <a href="#endpoints-PUTapi-races--id-">PUT api/races/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-DELETEapi-races--id-">
                                <a href="#endpoints-DELETEapi-races--id-">DELETE api/races/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-races--raceId--teams">
                                <a href="#endpoints-GETapi-races--raceId--teams">GET api/races/{raceId}/teams</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-user">
                                <a href="#endpoints-GETapi-user">GET api/user</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-user-is-admin">
                                <a href="#endpoints-GETapi-user-is-admin">GET api/user/is-admin</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-user-stats--id-">
                                <a href="#endpoints-GETapi-user-stats--id-">GET api/user/stats/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-user-history--id-">
                                <a href="#endpoints-GETapi-user-history--id-">GET api/user/history/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-users">
                                <a href="#endpoints-GETapi-users">GET api/users</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-users--id-">
                                <a href="#endpoints-GETapi-users--id-">GET api/users/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-PUTapi-users--id-">
                                <a href="#endpoints-PUTapi-users--id-">PUT api/users/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-DELETEapi-users--id-">
                                <a href="#endpoints-DELETEapi-users--id-">DELETE api/users/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-users-races-register">
                                <a href="#endpoints-POSTapi-users-races-register">POST api/users/races/register</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-teams">
                                <a href="#endpoints-POSTapi-teams">POST api/teams</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-teams-addMember">
                                <a href="#endpoints-POSTapi-teams-addMember">POST api/teams/addMember</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-races--raceId--available-users">
                                <a href="#endpoints-GETapi-races--raceId--available-users">Get users for a specific race with availability status
Returns all matching gender users, flagging those unavailable</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-teams--teamId--register-race">
                                <a href="#endpoints-POSTapi-teams--teamId--register-race">Register a team to a race</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-teams--teamId--races--raceId-">
                                <a href="#endpoints-GETapi-teams--teamId--races--raceId-">Get team details for a specific race (including members' race info)</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-teams-member-remove">
                                <a href="#endpoints-POSTapi-teams-member-remove">Remove a member from the team and race</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-teams-member-update-info">
                                <a href="#endpoints-POSTapi-teams-member-update-info">Update member's race info (PPS, Chip)</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-teams-validate-race">
                                <a href="#endpoints-POSTapi-teams-validate-race">Validate the team for the race</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-teams-unvalidate-race">
                                <a href="#endpoints-POSTapi-teams-unvalidate-race">Unvalidate the team for the race (if race hasn't started)</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-teams--id-">
                                <a href="#endpoints-GETapi-teams--id-">GET api/teams/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-teams--teamId--users">
                                <a href="#endpoints-GETapi-teams--teamId--users">GET api/teams/{teamId}/users</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-addresses--id-">
                                <a href="#endpoints-GETapi-addresses--id-">GET api/addresses/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-addresses">
                                <a href="#endpoints-POSTapi-addresses">POST api/addresses</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-PUTapi-addresses--id-">
                                <a href="#endpoints-PUTapi-addresses--id-">PUT api/addresses/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-clubs--id--members-add">
                                <a href="#endpoints-POSTapi-clubs--id--members-add">POST api/clubs/{id}/members/add</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-clubs--id--members-remove">
                                <a href="#endpoints-POSTapi-clubs--id--members-remove">POST api/clubs/{id}/members/remove</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-roles">
                                <a href="#endpoints-GETapi-roles">GET api/roles</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-roles">
                                <a href="#endpoints-POSTapi-roles">POST api/roles</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-roles--id-">
                                <a href="#endpoints-GETapi-roles--id-">GET api/roles/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-PUTapi-roles--id-">
                                <a href="#endpoints-PUTapi-roles--id-">PUT api/roles/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-DELETEapi-roles--id-">
                                <a href="#endpoints-DELETEapi-roles--id-">DELETE api/roles/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-clubs">
                                <a href="#endpoints-POSTapi-clubs">POST api/clubs</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-clubs-with-address">
                                <a href="#endpoints-POSTapi-clubs-with-address">POST api/clubs/with-address</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-PUTapi-clubs--id-">
                                <a href="#endpoints-PUTapi-clubs--id-">PUT api/clubs/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-DELETEapi-clubs--id-">
                                <a href="#endpoints-DELETEapi-clubs--id-">DELETE api/clubs/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-GETapi-addresses">
                                <a href="#endpoints-GETapi-addresses">GET api/addresses</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-DELETEapi-addresses--id-">
                                <a href="#endpoints-DELETEapi-addresses--id-">DELETE api/addresses/{id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="endpoints-POSTapi-users--id-">
                                <a href="#endpoints-POSTapi-users--id-">POST api/users/{id}</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: January 15, 2026</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<aside>
    <strong>Base URL</strong>: <code>http://localhost</code>
</aside>
<pre><code>This documentation aims to provide all the information you need to work with our API.

&lt;aside&gt;As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).&lt;/aside&gt;</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>This API is not authenticated.</p>

        <h1 id="endpoints">Endpoints</h1>

    

                                <h2 id="endpoints-GETapi-reset">Reset the database and seed it with initial data
This endpoint is for development purposes only</h2>

<p>
</p>



<span id="example-requests-GETapi-reset">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/reset" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/reset"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-reset">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Database reset and seeded successfully&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-reset" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-reset"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-reset"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-reset" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-reset">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-reset" data-method="GET"
      data-path="api/reset"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-reset', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-reset"
                    onclick="tryItOut('GETapi-reset');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-reset"
                    onclick="cancelTryOut('GETapi-reset');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-reset"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/reset</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-reset"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-reset"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTapi-login">POST api/login</h2>

<p>
</p>



<span id="example-requests-POSTapi-login">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/login" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/login"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-login">
</span>
<span id="execution-results-POSTapi-login" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-login"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-login"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-login">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-login" data-method="POST"
      data-path="api/login"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-login', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-login"
                    onclick="tryItOut('POSTapi-login');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-login"
                    onclick="cancelTryOut('POSTapi-login');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-login"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/login</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTapi-logout">POST api/logout</h2>

<p>
</p>



<span id="example-requests-POSTapi-logout">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/logout" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/logout"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-logout">
</span>
<span id="execution-results-POSTapi-logout" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-logout"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-logout"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-logout" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-logout">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-logout" data-method="POST"
      data-path="api/logout"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-logout', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-logout"
                    onclick="tryItOut('POSTapi-logout');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-logout"
                    onclick="cancelTryOut('POSTapi-logout');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-logout"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/logout</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTapi-register">POST api/register</h2>

<p>
</p>



<span id="example-requests-POSTapi-register">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/register" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/register"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-register">
</span>
<span id="execution-results-POSTapi-register" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-register"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-register"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-register" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-register">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-register" data-method="POST"
      data-path="api/register"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-register', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-register"
                    onclick="tryItOut('POSTapi-register');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-register"
                    onclick="cancelTryOut('POSTapi-register');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-register"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/register</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-register"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-register"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-raids">GET api/raids</h2>

<p>
</p>



<span id="example-requests-GETapi-raids">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/raids" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/raids"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-raids">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;RAI_ID&quot;: 1,
            &quot;CLU_ID&quot;: 1,
            &quot;ADD_ID&quot;: 7,
            &quot;USE_ID&quot;: 4,
            &quot;RAI_NB_RACES&quot;: 5,
            &quot;RAI_NAME&quot;: &quot;Raid Cotentin 2026&quot;,
            &quot;RAI_MAIL&quot;: &quot;contact@raidcotentin.fr&quot;,
            &quot;RAI_PHONE_NUMBER&quot;: null,
            &quot;RAI_WEB_SITE&quot;: &quot;https://raidcotentin.fr&quot;,
            &quot;RAI_IMAGE&quot;: &quot;raid_cotentin.jpg&quot;,
            &quot;RAI_TIME_START&quot;: &quot;2025-10-10T08:00:00.000000Z&quot;,
            &quot;RAI_TIME_END&quot;: &quot;2025-10-10T20:00:00.000000Z&quot;,
            &quot;RAI_REGISTRATION_START&quot;: &quot;2025-09-01T00:00:00.000000Z&quot;,
            &quot;RAI_REGISTRATION_END&quot;: &quot;2026-09-30T23:59:59.000000Z&quot;,
            &quot;club&quot;: {
                &quot;CLU_ID&quot;: 1,
                &quot;USE_ID&quot;: 2,
                &quot;ADD_ID&quot;: 1,
                &quot;CLU_NAME&quot;: &quot;CO-DE&quot;
            },
            &quot;address&quot;: {
                &quot;ADD_ID&quot;: 7,
                &quot;ADD_POSTAL_CODE&quot;: 50110,
                &quot;ADD_CITY&quot;: &quot;Tourlaville&quot;,
                &quot;ADD_STREET_NAME&quot;: &quot;Rue des Mielles&quot;,
                &quot;ADD_STREET_NUMBER&quot;: &quot;10&quot;
            },
            &quot;user&quot;: {
                &quot;USE_ID&quot;: 4,
                &quot;ADD_ID&quot;: 2,
                &quot;CLU_ID&quot;: 1,
                &quot;USE_MAIL&quot;: &quot;loane.kante@example.com&quot;,
                &quot;USE_NAME&quot;: &quot;Loane&quot;,
                &quot;USE_LAST_NAME&quot;: &quot;Kante&quot;,
                &quot;USE_GENDER&quot;: &quot;Femme&quot;,
                &quot;USE_BIRTHDATE&quot;: &quot;2000-05-10T00:00:00.000000Z&quot;,
                &quot;USE_PHONE_NUMBER&quot;: 610000004,
                &quot;USE_LICENCE_NUMBER&quot;: 100006,
                &quot;USE_MEMBERSHIP_DATE&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
                &quot;USE_VALIDITY&quot;: &quot;2021-06-30T00:00:00.000000Z&quot;
            }
        },
        {
            &quot;RAI_ID&quot;: 2,
            &quot;CLU_ID&quot;: 2,
            &quot;ADD_ID&quot;: 4,
            &quot;USE_ID&quot;: 5,
            &quot;RAI_NB_RACES&quot;: 5,
            &quot;RAI_NAME&quot;: &quot;Raid de Vanves 2025&quot;,
            &quot;RAI_MAIL&quot;: &quot;contact@trailvanves.fr&quot;,
            &quot;RAI_PHONE_NUMBER&quot;: null,
            &quot;RAI_WEB_SITE&quot;: &quot;https://trailfalaises.fr&quot;,
            &quot;RAI_IMAGE&quot;: &quot;trail_falaises.jpg&quot;,
            &quot;RAI_TIME_START&quot;: &quot;2026-04-20T07:30:00.000000Z&quot;,
            &quot;RAI_TIME_END&quot;: &quot;2026-04-20T19:00:00.000000Z&quot;,
            &quot;RAI_REGISTRATION_START&quot;: &quot;2025-12-01T00:00:00.000000Z&quot;,
            &quot;RAI_REGISTRATION_END&quot;: &quot;2026-04-15T23:59:59.000000Z&quot;,
            &quot;club&quot;: {
                &quot;CLU_ID&quot;: 2,
                &quot;USE_ID&quot;: 3,
                &quot;ADD_ID&quot;: 3,
                &quot;CLU_NAME&quot;: &quot;L&#039;Embuscade&quot;
            },
            &quot;address&quot;: {
                &quot;ADD_ID&quot;: 4,
                &quot;ADD_POSTAL_CODE&quot;: 76790,
                &quot;ADD_CITY&quot;: &quot;&Eacute;tretat&quot;,
                &quot;ADD_STREET_NAME&quot;: &quot;Rue des Falaises&quot;,
                &quot;ADD_STREET_NUMBER&quot;: &quot;3&quot;
            },
            &quot;user&quot;: {
                &quot;USE_ID&quot;: 5,
                &quot;ADD_ID&quot;: 3,
                &quot;CLU_ID&quot;: 2,
                &quot;USE_MAIL&quot;: &quot;jack.sparrow@example.com&quot;,
                &quot;USE_NAME&quot;: &quot;Jack&quot;,
                &quot;USE_LAST_NAME&quot;: &quot;Sparrow&quot;,
                &quot;USE_GENDER&quot;: &quot;Homme&quot;,
                &quot;USE_BIRTHDATE&quot;: &quot;1978-03-15T00:00:00.000000Z&quot;,
                &quot;USE_PHONE_NUMBER&quot;: 610000005,
                &quot;USE_LICENCE_NUMBER&quot;: 100007,
                &quot;USE_MEMBERSHIP_DATE&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
                &quot;USE_VALIDITY&quot;: &quot;2022-06-07T00:00:00.000000Z&quot;
            }
        },
        {
            &quot;RAI_ID&quot;: 3,
            &quot;CLU_ID&quot;: 3,
            &quot;ADD_ID&quot;: 2,
            &quot;USE_ID&quot;: 12,
            &quot;RAI_NB_RACES&quot;: 4,
            &quot;RAI_NAME&quot;: &quot;RAID OBIWAK&quot;,
            &quot;RAI_MAIL&quot;: &quot;contact@obiwak.raid.fr&quot;,
            &quot;RAI_PHONE_NUMBER&quot;: null,
            &quot;RAI_WEB_SITE&quot;: &quot;https://obiwak_raid.fr&quot;,
            &quot;RAI_IMAGE&quot;: &quot;trail_falaises.jpg&quot;,
            &quot;RAI_TIME_START&quot;: &quot;2026-08-20T07:30:00.000000Z&quot;,
            &quot;RAI_TIME_END&quot;: &quot;2026-08-20T19:00:00.000000Z&quot;,
            &quot;RAI_REGISTRATION_START&quot;: &quot;2026-04-01T00:00:00.000000Z&quot;,
            &quot;RAI_REGISTRATION_END&quot;: &quot;2026-04-30T23:59:59.000000Z&quot;,
            &quot;club&quot;: {
                &quot;CLU_ID&quot;: 3,
                &quot;USE_ID&quot;: 13,
                &quot;ADD_ID&quot;: 5,
                &quot;CLU_NAME&quot;: &quot;CO AZIMUT 77&quot;
            },
            &quot;address&quot;: {
                &quot;ADD_ID&quot;: 2,
                &quot;ADD_POSTAL_CODE&quot;: 50100,
                &quot;ADD_CITY&quot;: &quot;Alen&ccedil;on&quot;,
                &quot;ADD_STREET_NAME&quot;: &quot;Rue Victor Hugo&quot;,
                &quot;ADD_STREET_NUMBER&quot;: &quot;5&quot;
            },
            &quot;user&quot;: {
                &quot;USE_ID&quot;: 12,
                &quot;ADD_ID&quot;: 2,
                &quot;CLU_ID&quot;: 3,
                &quot;USE_MAIL&quot;: &quot;paul.dorbec@example.com&quot;,
                &quot;USE_NAME&quot;: &quot;Paul&quot;,
                &quot;USE_LAST_NAME&quot;: &quot;Dorbec&quot;,
                &quot;USE_GENDER&quot;: &quot;Homme&quot;,
                &quot;USE_BIRTHDATE&quot;: &quot;1990-01-05T00:00:00.000000Z&quot;,
                &quot;USE_PHONE_NUMBER&quot;: 620000052,
                &quot;USE_LICENCE_NUMBER&quot;: 200012,
                &quot;USE_MEMBERSHIP_DATE&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
                &quot;USE_VALIDITY&quot;: &quot;2022-08-31T00:00:00.000000Z&quot;
            }
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-raids" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-raids"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-raids"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-raids" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-raids">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-raids" data-method="GET"
      data-path="api/raids"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-raids', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-raids"
                    onclick="tryItOut('GETapi-raids');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-raids"
                    onclick="cancelTryOut('GETapi-raids');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-raids"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/raids</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-raids"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-raids"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-raids--id-">GET api/raids/{id}</h2>

<p>
</p>



<span id="example-requests-GETapi-raids--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/raids/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/raids/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-raids--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;RAI_ID&quot;: 1,
        &quot;CLU_ID&quot;: 1,
        &quot;ADD_ID&quot;: 7,
        &quot;USE_ID&quot;: 4,
        &quot;RAI_NB_RACES&quot;: 5,
        &quot;RAI_NAME&quot;: &quot;Raid Cotentin 2026&quot;,
        &quot;RAI_MAIL&quot;: &quot;contact@raidcotentin.fr&quot;,
        &quot;RAI_PHONE_NUMBER&quot;: null,
        &quot;RAI_WEB_SITE&quot;: &quot;https://raidcotentin.fr&quot;,
        &quot;RAI_IMAGE&quot;: &quot;raid_cotentin.jpg&quot;,
        &quot;RAI_TIME_START&quot;: &quot;2025-10-10T08:00:00.000000Z&quot;,
        &quot;RAI_TIME_END&quot;: &quot;2025-10-10T20:00:00.000000Z&quot;,
        &quot;RAI_REGISTRATION_START&quot;: &quot;2025-09-01T00:00:00.000000Z&quot;,
        &quot;RAI_REGISTRATION_END&quot;: &quot;2026-09-30T23:59:59.000000Z&quot;,
        &quot;club&quot;: {
            &quot;CLU_ID&quot;: 1,
            &quot;USE_ID&quot;: 2,
            &quot;ADD_ID&quot;: 1,
            &quot;CLU_NAME&quot;: &quot;CO-DE&quot;
        },
        &quot;address&quot;: {
            &quot;ADD_ID&quot;: 7,
            &quot;ADD_POSTAL_CODE&quot;: 50110,
            &quot;ADD_CITY&quot;: &quot;Tourlaville&quot;,
            &quot;ADD_STREET_NAME&quot;: &quot;Rue des Mielles&quot;,
            &quot;ADD_STREET_NUMBER&quot;: &quot;10&quot;
        },
        &quot;user&quot;: {
            &quot;USE_ID&quot;: 4,
            &quot;ADD_ID&quot;: 2,
            &quot;CLU_ID&quot;: 1,
            &quot;USE_MAIL&quot;: &quot;loane.kante@example.com&quot;,
            &quot;USE_NAME&quot;: &quot;Loane&quot;,
            &quot;USE_LAST_NAME&quot;: &quot;Kante&quot;,
            &quot;USE_GENDER&quot;: &quot;Femme&quot;,
            &quot;USE_BIRTHDATE&quot;: &quot;2000-05-10T00:00:00.000000Z&quot;,
            &quot;USE_PHONE_NUMBER&quot;: 610000004,
            &quot;USE_LICENCE_NUMBER&quot;: 100006,
            &quot;USE_MEMBERSHIP_DATE&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
            &quot;USE_VALIDITY&quot;: &quot;2021-06-30T00:00:00.000000Z&quot;
        }
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-raids--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-raids--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-raids--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-raids--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-raids--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-raids--id-" data-method="GET"
      data-path="api/raids/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-raids--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-raids--id-"
                    onclick="tryItOut('GETapi-raids--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-raids--id-"
                    onclick="cancelTryOut('GETapi-raids--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-raids--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/raids/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-raids--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-raids--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-raids--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the raid. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-raids--raidId--races">GET api/raids/{raidId}/races</h2>

<p>
</p>



<span id="example-requests-GETapi-raids--raidId--races">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/raids/1/races" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/raids/1/races"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-raids--raidId--races">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;RAC_ID&quot;: 1,
            &quot;USE_ID&quot;: 4,
            &quot;RAI_ID&quot;: 1,
            &quot;RAC_NAME&quot;: &quot;Trail Mixte Loisir&quot;,
            &quot;RAC_TIME_START&quot;: &quot;2025-10-10 08:30:00&quot;,
            &quot;RAC_TIME_END&quot;: &quot;2025-10-10 13:30:00&quot;,
            &quot;RAC_GENDER&quot;: &quot;Mixte&quot;,
            &quot;RAC_TYPE&quot;: &quot;Loisir&quot;,
            &quot;RAC_DIFFICULTY&quot;: &quot;Moyen&quot;,
            &quot;RAC_MIN_PARTICIPANTS&quot;: 5,
            &quot;RAC_MAX_PARTICIPANTS&quot;: 200,
            &quot;RAC_MIN_TEAMS&quot;: 2,
            &quot;RAC_MAX_TEAMS&quot;: 50,
            &quot;RAC_MAX_TEAM_MEMBERS&quot;: 3,
            &quot;RAC_AGE_MIN&quot;: 12,
            &quot;RAC_AGE_MIDDLE&quot;: 15,
            &quot;RAC_AGE_MAX&quot;: 18,
            &quot;RAC_CHIP_MANDATORY&quot;: 0,
            &quot;user&quot;: {
                &quot;USE_ID&quot;: 4,
                &quot;ADD_ID&quot;: 2,
                &quot;CLU_ID&quot;: 1,
                &quot;USE_MAIL&quot;: &quot;loane.kante@example.com&quot;,
                &quot;USE_NAME&quot;: &quot;Loane&quot;,
                &quot;USE_LAST_NAME&quot;: &quot;Kante&quot;,
                &quot;USE_GENDER&quot;: &quot;Femme&quot;,
                &quot;USE_BIRTHDATE&quot;: &quot;2000-05-10T00:00:00.000000Z&quot;,
                &quot;USE_PHONE_NUMBER&quot;: 610000004,
                &quot;USE_LICENCE_NUMBER&quot;: 100006,
                &quot;USE_MEMBERSHIP_DATE&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
                &quot;USE_VALIDITY&quot;: &quot;2021-06-30T00:00:00.000000Z&quot;
            }
        },
        {
            &quot;RAC_ID&quot;: 2,
            &quot;USE_ID&quot;: 4,
            &quot;RAI_ID&quot;: 1,
            &quot;RAC_NAME&quot;: &quot;Trail Hommes Comp&eacute;titif&quot;,
            &quot;RAC_TIME_START&quot;: &quot;2025-10-10 12:30:00&quot;,
            &quot;RAC_TIME_END&quot;: &quot;2025-10-10 18:30:00&quot;,
            &quot;RAC_GENDER&quot;: &quot;Homme&quot;,
            &quot;RAC_TYPE&quot;: &quot;Comp&eacute;titif&quot;,
            &quot;RAC_DIFFICULTY&quot;: &quot;Difficile&quot;,
            &quot;RAC_MIN_PARTICIPANTS&quot;: 4,
            &quot;RAC_MAX_PARTICIPANTS&quot;: 150,
            &quot;RAC_MIN_TEAMS&quot;: 2,
            &quot;RAC_MAX_TEAMS&quot;: 40,
            &quot;RAC_MAX_TEAM_MEMBERS&quot;: 2,
            &quot;RAC_AGE_MIN&quot;: 18,
            &quot;RAC_AGE_MIDDLE&quot;: 25,
            &quot;RAC_AGE_MAX&quot;: 30,
            &quot;RAC_CHIP_MANDATORY&quot;: 1,
            &quot;user&quot;: {
                &quot;USE_ID&quot;: 4,
                &quot;ADD_ID&quot;: 2,
                &quot;CLU_ID&quot;: 1,
                &quot;USE_MAIL&quot;: &quot;loane.kante@example.com&quot;,
                &quot;USE_NAME&quot;: &quot;Loane&quot;,
                &quot;USE_LAST_NAME&quot;: &quot;Kante&quot;,
                &quot;USE_GENDER&quot;: &quot;Femme&quot;,
                &quot;USE_BIRTHDATE&quot;: &quot;2000-05-10T00:00:00.000000Z&quot;,
                &quot;USE_PHONE_NUMBER&quot;: 610000004,
                &quot;USE_LICENCE_NUMBER&quot;: 100006,
                &quot;USE_MEMBERSHIP_DATE&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
                &quot;USE_VALIDITY&quot;: &quot;2021-06-30T00:00:00.000000Z&quot;
            }
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-raids--raidId--races" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-raids--raidId--races"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-raids--raidId--races"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-raids--raidId--races" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-raids--raidId--races">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-raids--raidId--races" data-method="GET"
      data-path="api/raids/{raidId}/races"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-raids--raidId--races', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-raids--raidId--races"
                    onclick="tryItOut('GETapi-raids--raidId--races');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-raids--raidId--races"
                    onclick="cancelTryOut('GETapi-raids--raidId--races');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-raids--raidId--races"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/raids/{raidId}/races</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-raids--raidId--races"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-raids--raidId--races"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>raidId</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="raidId"                data-endpoint="GETapi-raids--raidId--races"
               value="1"
               data-component="url">
    <br>
<p>Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-races">GET api/races</h2>

<p>
</p>



<span id="example-requests-GETapi-races">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/races" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/races"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-races">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;RAC_ID&quot;: 1,
            &quot;USE_ID&quot;: 4,
            &quot;RAI_ID&quot;: 1,
            &quot;RAC_NAME&quot;: &quot;Trail Mixte Loisir&quot;,
            &quot;RAC_TIME_START&quot;: &quot;2025-10-10 08:30:00&quot;,
            &quot;RAC_TIME_END&quot;: &quot;2025-10-10 13:30:00&quot;,
            &quot;RAC_GENDER&quot;: &quot;Mixte&quot;,
            &quot;RAC_TYPE&quot;: &quot;Loisir&quot;,
            &quot;RAC_DIFFICULTY&quot;: &quot;Moyen&quot;,
            &quot;RAC_MIN_PARTICIPANTS&quot;: 5,
            &quot;RAC_MAX_PARTICIPANTS&quot;: 200,
            &quot;RAC_MIN_TEAMS&quot;: 2,
            &quot;RAC_MAX_TEAMS&quot;: 50,
            &quot;RAC_MAX_TEAM_MEMBERS&quot;: 3,
            &quot;RAC_AGE_MIN&quot;: 12,
            &quot;RAC_AGE_MIDDLE&quot;: 15,
            &quot;RAC_AGE_MAX&quot;: 18,
            &quot;RAC_CHIP_MANDATORY&quot;: 0,
            &quot;user&quot;: {
                &quot;USE_ID&quot;: 4,
                &quot;ADD_ID&quot;: 2,
                &quot;CLU_ID&quot;: 1,
                &quot;USE_MAIL&quot;: &quot;loane.kante@example.com&quot;,
                &quot;USE_NAME&quot;: &quot;Loane&quot;,
                &quot;USE_LAST_NAME&quot;: &quot;Kante&quot;,
                &quot;USE_GENDER&quot;: &quot;Femme&quot;,
                &quot;USE_BIRTHDATE&quot;: &quot;2000-05-10T00:00:00.000000Z&quot;,
                &quot;USE_PHONE_NUMBER&quot;: 610000004,
                &quot;USE_LICENCE_NUMBER&quot;: 100006,
                &quot;USE_MEMBERSHIP_DATE&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
                &quot;USE_VALIDITY&quot;: &quot;2021-06-30T00:00:00.000000Z&quot;
            },
            &quot;raid&quot;: {
                &quot;RAI_ID&quot;: 1,
                &quot;CLU_ID&quot;: 1,
                &quot;ADD_ID&quot;: 7,
                &quot;USE_ID&quot;: 4,
                &quot;RAI_NB_RACES&quot;: 5,
                &quot;RAI_NAME&quot;: &quot;Raid Cotentin 2026&quot;,
                &quot;RAI_MAIL&quot;: &quot;contact@raidcotentin.fr&quot;,
                &quot;RAI_PHONE_NUMBER&quot;: null,
                &quot;RAI_WEB_SITE&quot;: &quot;https://raidcotentin.fr&quot;,
                &quot;RAI_IMAGE&quot;: &quot;raid_cotentin.jpg&quot;,
                &quot;RAI_TIME_START&quot;: &quot;2025-10-10T08:00:00.000000Z&quot;,
                &quot;RAI_TIME_END&quot;: &quot;2025-10-10T20:00:00.000000Z&quot;,
                &quot;RAI_REGISTRATION_START&quot;: &quot;2025-09-01T00:00:00.000000Z&quot;,
                &quot;RAI_REGISTRATION_END&quot;: &quot;2026-09-30T23:59:59.000000Z&quot;
            }
        },
        {
            &quot;RAC_ID&quot;: 2,
            &quot;USE_ID&quot;: 4,
            &quot;RAI_ID&quot;: 1,
            &quot;RAC_NAME&quot;: &quot;Trail Hommes Comp&eacute;titif&quot;,
            &quot;RAC_TIME_START&quot;: &quot;2025-10-10 12:30:00&quot;,
            &quot;RAC_TIME_END&quot;: &quot;2025-10-10 18:30:00&quot;,
            &quot;RAC_GENDER&quot;: &quot;Homme&quot;,
            &quot;RAC_TYPE&quot;: &quot;Comp&eacute;titif&quot;,
            &quot;RAC_DIFFICULTY&quot;: &quot;Difficile&quot;,
            &quot;RAC_MIN_PARTICIPANTS&quot;: 4,
            &quot;RAC_MAX_PARTICIPANTS&quot;: 150,
            &quot;RAC_MIN_TEAMS&quot;: 2,
            &quot;RAC_MAX_TEAMS&quot;: 40,
            &quot;RAC_MAX_TEAM_MEMBERS&quot;: 2,
            &quot;RAC_AGE_MIN&quot;: 18,
            &quot;RAC_AGE_MIDDLE&quot;: 25,
            &quot;RAC_AGE_MAX&quot;: 30,
            &quot;RAC_CHIP_MANDATORY&quot;: 1,
            &quot;user&quot;: {
                &quot;USE_ID&quot;: 4,
                &quot;ADD_ID&quot;: 2,
                &quot;CLU_ID&quot;: 1,
                &quot;USE_MAIL&quot;: &quot;loane.kante@example.com&quot;,
                &quot;USE_NAME&quot;: &quot;Loane&quot;,
                &quot;USE_LAST_NAME&quot;: &quot;Kante&quot;,
                &quot;USE_GENDER&quot;: &quot;Femme&quot;,
                &quot;USE_BIRTHDATE&quot;: &quot;2000-05-10T00:00:00.000000Z&quot;,
                &quot;USE_PHONE_NUMBER&quot;: 610000004,
                &quot;USE_LICENCE_NUMBER&quot;: 100006,
                &quot;USE_MEMBERSHIP_DATE&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
                &quot;USE_VALIDITY&quot;: &quot;2021-06-30T00:00:00.000000Z&quot;
            },
            &quot;raid&quot;: {
                &quot;RAI_ID&quot;: 1,
                &quot;CLU_ID&quot;: 1,
                &quot;ADD_ID&quot;: 7,
                &quot;USE_ID&quot;: 4,
                &quot;RAI_NB_RACES&quot;: 5,
                &quot;RAI_NAME&quot;: &quot;Raid Cotentin 2026&quot;,
                &quot;RAI_MAIL&quot;: &quot;contact@raidcotentin.fr&quot;,
                &quot;RAI_PHONE_NUMBER&quot;: null,
                &quot;RAI_WEB_SITE&quot;: &quot;https://raidcotentin.fr&quot;,
                &quot;RAI_IMAGE&quot;: &quot;raid_cotentin.jpg&quot;,
                &quot;RAI_TIME_START&quot;: &quot;2025-10-10T08:00:00.000000Z&quot;,
                &quot;RAI_TIME_END&quot;: &quot;2025-10-10T20:00:00.000000Z&quot;,
                &quot;RAI_REGISTRATION_START&quot;: &quot;2025-09-01T00:00:00.000000Z&quot;,
                &quot;RAI_REGISTRATION_END&quot;: &quot;2026-09-30T23:59:59.000000Z&quot;
            }
        },
        {
            &quot;RAC_ID&quot;: 3,
            &quot;USE_ID&quot;: 6,
            &quot;RAI_ID&quot;: 2,
            &quot;RAC_NAME&quot;: &quot;Trail Femmes Comp&eacute;titif&quot;,
            &quot;RAC_TIME_START&quot;: &quot;2026-06-15 09:15:00&quot;,
            &quot;RAC_TIME_END&quot;: &quot;2026-06-15 13:15:00&quot;,
            &quot;RAC_GENDER&quot;: &quot;Femme&quot;,
            &quot;RAC_TYPE&quot;: &quot;Competitif&quot;,
            &quot;RAC_DIFFICULTY&quot;: &quot;Moyen&quot;,
            &quot;RAC_MIN_PARTICIPANTS&quot;: 6,
            &quot;RAC_MAX_PARTICIPANTS&quot;: 120,
            &quot;RAC_MIN_TEAMS&quot;: 2,
            &quot;RAC_MAX_TEAMS&quot;: 30,
            &quot;RAC_MAX_TEAM_MEMBERS&quot;: 3,
            &quot;RAC_AGE_MIN&quot;: 10,
            &quot;RAC_AGE_MIDDLE&quot;: 18,
            &quot;RAC_AGE_MAX&quot;: 20,
            &quot;RAC_CHIP_MANDATORY&quot;: 1,
            &quot;user&quot;: {
                &quot;USE_ID&quot;: 6,
                &quot;ADD_ID&quot;: 3,
                &quot;CLU_ID&quot;: 2,
                &quot;USE_MAIL&quot;: &quot;danielle.june.marsh@example.com&quot;,
                &quot;USE_NAME&quot;: &quot;Danielle&quot;,
                &quot;USE_LAST_NAME&quot;: &quot;Marsh&quot;,
                &quot;USE_GENDER&quot;: &quot;Femme&quot;,
                &quot;USE_BIRTHDATE&quot;: &quot;2005-03-11T00:00:00.000000Z&quot;,
                &quot;USE_PHONE_NUMBER&quot;: 610000722,
                &quot;USE_LICENCE_NUMBER&quot;: 100722,
                &quot;USE_MEMBERSHIP_DATE&quot;: &quot;2022-01-01T00:00:00.000000Z&quot;,
                &quot;USE_VALIDITY&quot;: &quot;2021-12-31T00:00:00.000000Z&quot;
            },
            &quot;raid&quot;: {
                &quot;RAI_ID&quot;: 2,
                &quot;CLU_ID&quot;: 2,
                &quot;ADD_ID&quot;: 4,
                &quot;USE_ID&quot;: 5,
                &quot;RAI_NB_RACES&quot;: 5,
                &quot;RAI_NAME&quot;: &quot;Raid de Vanves 2025&quot;,
                &quot;RAI_MAIL&quot;: &quot;contact@trailvanves.fr&quot;,
                &quot;RAI_PHONE_NUMBER&quot;: null,
                &quot;RAI_WEB_SITE&quot;: &quot;https://trailfalaises.fr&quot;,
                &quot;RAI_IMAGE&quot;: &quot;trail_falaises.jpg&quot;,
                &quot;RAI_TIME_START&quot;: &quot;2026-04-20T07:30:00.000000Z&quot;,
                &quot;RAI_TIME_END&quot;: &quot;2026-04-20T19:00:00.000000Z&quot;,
                &quot;RAI_REGISTRATION_START&quot;: &quot;2025-12-01T00:00:00.000000Z&quot;,
                &quot;RAI_REGISTRATION_END&quot;: &quot;2026-04-15T23:59:59.000000Z&quot;
            }
        },
        {
            &quot;RAC_ID&quot;: 4,
            &quot;USE_ID&quot;: 8,
            &quot;RAI_ID&quot;: 2,
            &quot;RAC_NAME&quot;: &quot;Trail Hommes Loisir&quot;,
            &quot;RAC_TIME_START&quot;: &quot;2026-04-20 08:00:00&quot;,
            &quot;RAC_TIME_END&quot;: &quot;2026-04-20 11:30:00&quot;,
            &quot;RAC_GENDER&quot;: &quot;Homme&quot;,
            &quot;RAC_TYPE&quot;: &quot;Loisir&quot;,
            &quot;RAC_DIFFICULTY&quot;: &quot;Facile&quot;,
            &quot;RAC_MIN_PARTICIPANTS&quot;: 4,
            &quot;RAC_MAX_PARTICIPANTS&quot;: 300,
            &quot;RAC_MIN_TEAMS&quot;: 2,
            &quot;RAC_MAX_TEAMS&quot;: 60,
            &quot;RAC_MAX_TEAM_MEMBERS&quot;: 2,
            &quot;RAC_AGE_MIN&quot;: 14,
            &quot;RAC_AGE_MIDDLE&quot;: 17,
            &quot;RAC_AGE_MAX&quot;: 19,
            &quot;RAC_CHIP_MANDATORY&quot;: 1,
            &quot;user&quot;: {
                &quot;USE_ID&quot;: 8,
                &quot;ADD_ID&quot;: 5,
                &quot;CLU_ID&quot;: 1,
                &quot;USE_MAIL&quot;: &quot;bob.douglas@example.com&quot;,
                &quot;USE_NAME&quot;: &quot;Bob&quot;,
                &quot;USE_LAST_NAME&quot;: &quot;Douglas&quot;,
                &quot;USE_GENDER&quot;: &quot;Homme&quot;,
                &quot;USE_BIRTHDATE&quot;: &quot;1992-02-01T00:00:00.000000Z&quot;,
                &quot;USE_PHONE_NUMBER&quot;: 620000005,
                &quot;USE_LICENCE_NUMBER&quot;: 200002,
                &quot;USE_MEMBERSHIP_DATE&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
                &quot;USE_VALIDITY&quot;: &quot;2022-02-28T00:00:00.000000Z&quot;
            },
            &quot;raid&quot;: {
                &quot;RAI_ID&quot;: 2,
                &quot;CLU_ID&quot;: 2,
                &quot;ADD_ID&quot;: 4,
                &quot;USE_ID&quot;: 5,
                &quot;RAI_NB_RACES&quot;: 5,
                &quot;RAI_NAME&quot;: &quot;Raid de Vanves 2025&quot;,
                &quot;RAI_MAIL&quot;: &quot;contact@trailvanves.fr&quot;,
                &quot;RAI_PHONE_NUMBER&quot;: null,
                &quot;RAI_WEB_SITE&quot;: &quot;https://trailfalaises.fr&quot;,
                &quot;RAI_IMAGE&quot;: &quot;trail_falaises.jpg&quot;,
                &quot;RAI_TIME_START&quot;: &quot;2026-04-20T07:30:00.000000Z&quot;,
                &quot;RAI_TIME_END&quot;: &quot;2026-04-20T19:00:00.000000Z&quot;,
                &quot;RAI_REGISTRATION_START&quot;: &quot;2025-12-01T00:00:00.000000Z&quot;,
                &quot;RAI_REGISTRATION_END&quot;: &quot;2026-04-15T23:59:59.000000Z&quot;
            }
        },
        {
            &quot;RAC_ID&quot;: 5,
            &quot;USE_ID&quot;: 15,
            &quot;RAI_ID&quot;: 3,
            &quot;RAC_NAME&quot;: &quot;PARCOURS B&quot;,
            &quot;RAC_TIME_START&quot;: &quot;2026-08-20 09:00:00&quot;,
            &quot;RAC_TIME_END&quot;: &quot;2026-08-20 12:00:00&quot;,
            &quot;RAC_GENDER&quot;: &quot;Mixte&quot;,
            &quot;RAC_TYPE&quot;: &quot;Competitif&quot;,
            &quot;RAC_DIFFICULTY&quot;: &quot;Moyen&quot;,
            &quot;RAC_MIN_PARTICIPANTS&quot;: 4,
            &quot;RAC_MAX_PARTICIPANTS&quot;: 100,
            &quot;RAC_MIN_TEAMS&quot;: 2,
            &quot;RAC_MAX_TEAMS&quot;: 25,
            &quot;RAC_MAX_TEAM_MEMBERS&quot;: 3,
            &quot;RAC_AGE_MIN&quot;: 16,
            &quot;RAC_AGE_MIDDLE&quot;: 25,
            &quot;RAC_AGE_MAX&quot;: 35,
            &quot;RAC_CHIP_MANDATORY&quot;: 1,
            &quot;user&quot;: {
                &quot;USE_ID&quot;: 15,
                &quot;ADD_ID&quot;: 11,
                &quot;CLU_ID&quot;: 3,
                &quot;USE_MAIL&quot;: &quot;julien.martin@example.com&quot;,
                &quot;USE_NAME&quot;: &quot;Julien&quot;,
                &quot;USE_LAST_NAME&quot;: &quot;Martin&quot;,
                &quot;USE_GENDER&quot;: &quot;Homme&quot;,
                &quot;USE_BIRTHDATE&quot;: &quot;1989-03-22T00:00:00.000000Z&quot;,
                &quot;USE_PHONE_NUMBER&quot;: 620000021,
                &quot;USE_LICENCE_NUMBER&quot;: 200021,
                &quot;USE_MEMBERSHIP_DATE&quot;: &quot;2022-01-01T00:00:00.000000Z&quot;,
                &quot;USE_VALIDITY&quot;: &quot;2024-12-31T00:00:00.000000Z&quot;
            },
            &quot;raid&quot;: {
                &quot;RAI_ID&quot;: 3,
                &quot;CLU_ID&quot;: 3,
                &quot;ADD_ID&quot;: 2,
                &quot;USE_ID&quot;: 12,
                &quot;RAI_NB_RACES&quot;: 4,
                &quot;RAI_NAME&quot;: &quot;RAID OBIWAK&quot;,
                &quot;RAI_MAIL&quot;: &quot;contact@obiwak.raid.fr&quot;,
                &quot;RAI_PHONE_NUMBER&quot;: null,
                &quot;RAI_WEB_SITE&quot;: &quot;https://obiwak_raid.fr&quot;,
                &quot;RAI_IMAGE&quot;: &quot;trail_falaises.jpg&quot;,
                &quot;RAI_TIME_START&quot;: &quot;2026-08-20T07:30:00.000000Z&quot;,
                &quot;RAI_TIME_END&quot;: &quot;2026-08-20T19:00:00.000000Z&quot;,
                &quot;RAI_REGISTRATION_START&quot;: &quot;2026-04-01T00:00:00.000000Z&quot;,
                &quot;RAI_REGISTRATION_END&quot;: &quot;2026-04-30T23:59:59.000000Z&quot;
            }
        },
        {
            &quot;RAC_ID&quot;: 6,
            &quot;USE_ID&quot;: 15,
            &quot;RAI_ID&quot;: 3,
            &quot;RAC_NAME&quot;: &quot;LUTIN&quot;,
            &quot;RAC_TIME_START&quot;: &quot;2026-08-20 10:00:00&quot;,
            &quot;RAC_TIME_END&quot;: &quot;2026-08-20 11:30:00&quot;,
            &quot;RAC_GENDER&quot;: &quot;Mixte&quot;,
            &quot;RAC_TYPE&quot;: &quot;Loisir&quot;,
            &quot;RAC_DIFFICULTY&quot;: &quot;Facile&quot;,
            &quot;RAC_MIN_PARTICIPANTS&quot;: 5,
            &quot;RAC_MAX_PARTICIPANTS&quot;: 150,
            &quot;RAC_MIN_TEAMS&quot;: 2,
            &quot;RAC_MAX_TEAMS&quot;: 40,
            &quot;RAC_MAX_TEAM_MEMBERS&quot;: 4,
            &quot;RAC_AGE_MIN&quot;: 10,
            &quot;RAC_AGE_MIDDLE&quot;: 15,
            &quot;RAC_AGE_MAX&quot;: 18,
            &quot;RAC_CHIP_MANDATORY&quot;: 0,
            &quot;user&quot;: {
                &quot;USE_ID&quot;: 15,
                &quot;ADD_ID&quot;: 11,
                &quot;CLU_ID&quot;: 3,
                &quot;USE_MAIL&quot;: &quot;julien.martin@example.com&quot;,
                &quot;USE_NAME&quot;: &quot;Julien&quot;,
                &quot;USE_LAST_NAME&quot;: &quot;Martin&quot;,
                &quot;USE_GENDER&quot;: &quot;Homme&quot;,
                &quot;USE_BIRTHDATE&quot;: &quot;1989-03-22T00:00:00.000000Z&quot;,
                &quot;USE_PHONE_NUMBER&quot;: 620000021,
                &quot;USE_LICENCE_NUMBER&quot;: 200021,
                &quot;USE_MEMBERSHIP_DATE&quot;: &quot;2022-01-01T00:00:00.000000Z&quot;,
                &quot;USE_VALIDITY&quot;: &quot;2024-12-31T00:00:00.000000Z&quot;
            },
            &quot;raid&quot;: {
                &quot;RAI_ID&quot;: 3,
                &quot;CLU_ID&quot;: 3,
                &quot;ADD_ID&quot;: 2,
                &quot;USE_ID&quot;: 12,
                &quot;RAI_NB_RACES&quot;: 4,
                &quot;RAI_NAME&quot;: &quot;RAID OBIWAK&quot;,
                &quot;RAI_MAIL&quot;: &quot;contact@obiwak.raid.fr&quot;,
                &quot;RAI_PHONE_NUMBER&quot;: null,
                &quot;RAI_WEB_SITE&quot;: &quot;https://obiwak_raid.fr&quot;,
                &quot;RAI_IMAGE&quot;: &quot;trail_falaises.jpg&quot;,
                &quot;RAI_TIME_START&quot;: &quot;2026-08-20T07:30:00.000000Z&quot;,
                &quot;RAI_TIME_END&quot;: &quot;2026-08-20T19:00:00.000000Z&quot;,
                &quot;RAI_REGISTRATION_START&quot;: &quot;2026-04-01T00:00:00.000000Z&quot;,
                &quot;RAI_REGISTRATION_END&quot;: &quot;2026-04-30T23:59:59.000000Z&quot;
            }
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-races" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-races"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-races"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-races" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-races">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-races" data-method="GET"
      data-path="api/races"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-races', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-races"
                    onclick="tryItOut('GETapi-races');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-races"
                    onclick="cancelTryOut('GETapi-races');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-races"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/races</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-races"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-races"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-races--id-">GET api/races/{id}</h2>

<p>
</p>



<span id="example-requests-GETapi-races--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/races/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/races/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-races--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;RAC_ID&quot;: 1,
        &quot;USE_ID&quot;: 4,
        &quot;RAI_ID&quot;: 1,
        &quot;RAC_NAME&quot;: &quot;Trail Mixte Loisir&quot;,
        &quot;RAC_TIME_START&quot;: &quot;2025-10-10 08:30:00&quot;,
        &quot;RAC_TIME_END&quot;: &quot;2025-10-10 13:30:00&quot;,
        &quot;RAC_GENDER&quot;: &quot;Mixte&quot;,
        &quot;RAC_TYPE&quot;: &quot;Loisir&quot;,
        &quot;RAC_DIFFICULTY&quot;: &quot;Moyen&quot;,
        &quot;RAC_MIN_PARTICIPANTS&quot;: 5,
        &quot;RAC_MAX_PARTICIPANTS&quot;: 200,
        &quot;RAC_MIN_TEAMS&quot;: 2,
        &quot;RAC_MAX_TEAMS&quot;: 50,
        &quot;RAC_MAX_TEAM_MEMBERS&quot;: 3,
        &quot;RAC_AGE_MIN&quot;: 12,
        &quot;RAC_AGE_MIDDLE&quot;: 15,
        &quot;RAC_AGE_MAX&quot;: 18,
        &quot;RAC_CHIP_MANDATORY&quot;: 0
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-races--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-races--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-races--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-races--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-races--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-races--id-" data-method="GET"
      data-path="api/races/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-races--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-races--id-"
                    onclick="tryItOut('GETapi-races--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-races--id-"
                    onclick="cancelTryOut('GETapi-races--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-races--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/races/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-races--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-races--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-races--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the race. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-races--id--details">GET api/races/{id}/details</h2>

<p>
</p>



<span id="example-requests-GETapi-races--id--details">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/races/1/details" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/races/1/details"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-races--id--details">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;RAC_ID&quot;: 1,
        &quot;USE_ID&quot;: 4,
        &quot;RAI_ID&quot;: 1,
        &quot;RAC_NAME&quot;: &quot;Trail Mixte Loisir&quot;,
        &quot;RAC_TIME_START&quot;: &quot;2025-10-10 08:30:00&quot;,
        &quot;RAC_TIME_END&quot;: &quot;2025-10-10 13:30:00&quot;,
        &quot;RAC_GENDER&quot;: &quot;Mixte&quot;,
        &quot;RAC_TYPE&quot;: &quot;Loisir&quot;,
        &quot;RAC_DIFFICULTY&quot;: &quot;Moyen&quot;,
        &quot;RAC_MIN_PARTICIPANTS&quot;: 5,
        &quot;RAC_MAX_PARTICIPANTS&quot;: 200,
        &quot;RAC_MIN_TEAMS&quot;: 2,
        &quot;RAC_MAX_TEAMS&quot;: 50,
        &quot;RAC_MAX_TEAM_MEMBERS&quot;: 3,
        &quot;RAC_AGE_MIN&quot;: 12,
        &quot;RAC_AGE_MIDDLE&quot;: 15,
        &quot;RAC_AGE_MAX&quot;: 18,
        &quot;RAC_CHIP_MANDATORY&quot;: 0,
        &quot;categories&quot;: [
            {
                &quot;CAT_ID&quot;: 1,
                &quot;CAT_LABEL&quot;: &quot;Mineur&quot;,
                &quot;pivot&quot;: {
                    &quot;RAC_ID&quot;: 1,
                    &quot;CAT_ID&quot;: 1,
                    &quot;CAR_PRICE&quot;: 8
                }
            },
            {
                &quot;CAT_ID&quot;: 2,
                &quot;CAT_LABEL&quot;: &quot;Majeur non licenci&eacute;&quot;,
                &quot;pivot&quot;: {
                    &quot;RAC_ID&quot;: 1,
                    &quot;CAT_ID&quot;: 2,
                    &quot;CAR_PRICE&quot;: 12
                }
            },
            {
                &quot;CAT_ID&quot;: 3,
                &quot;CAT_LABEL&quot;: &quot;Licensi&eacute;&quot;,
                &quot;pivot&quot;: {
                    &quot;RAC_ID&quot;: 1,
                    &quot;CAT_ID&quot;: 3,
                    &quot;CAR_PRICE&quot;: 7
                }
            }
        ],
        &quot;stats&quot;: {
            &quot;teams_count&quot;: 2,
            &quot;participants_count&quot;: 6,
            &quot;places_remaining&quot;: 194,
            &quot;filling_rate&quot;: 3,
            &quot;participants_expected_min&quot;: 5,
            &quot;participants_expected_max&quot;: 200
        },
        &quot;formatted_categories&quot;: [
            {
                &quot;id&quot;: 1,
                &quot;label&quot;: &quot;Mineur&quot;,
                &quot;price&quot;: 8
            },
            {
                &quot;id&quot;: 2,
                &quot;label&quot;: &quot;Majeur non licenci&eacute;&quot;,
                &quot;price&quot;: 12
            },
            {
                &quot;id&quot;: 3,
                &quot;label&quot;: &quot;Licensi&eacute;&quot;,
                &quot;price&quot;: 7
            }
        ],
        &quot;teams_list&quot;: [
            {
                &quot;id&quot;: 1,
                &quot;name&quot;: &quot;Lunatic&quot;,
                &quot;image&quot;: null,
                &quot;members_count&quot;: 3,
                &quot;responsible&quot;: {
                    &quot;id&quot;: 2,
                    &quot;name&quot;: &quot;Marc Marquez&quot;
                },
                &quot;members&quot;: [
                    {
                        &quot;id&quot;: 7,
                        &quot;name&quot;: &quot;Alice Durand&quot;,
                        &quot;email&quot;: &quot;alice.durand@example.com&quot;
                    },
                    {
                        &quot;id&quot;: 8,
                        &quot;name&quot;: &quot;Bob Douglas&quot;,
                        &quot;email&quot;: &quot;bob.douglas@example.com&quot;
                    },
                    {
                        &quot;id&quot;: 9,
                        &quot;name&quot;: &quot;Hugo Dialo&quot;,
                        &quot;email&quot;: &quot;hugo.dialo@example.com&quot;
                    }
                ]
            },
            {
                &quot;id&quot;: 3,
                &quot;name&quot;: &quot;Arctic Mokeys&quot;,
                &quot;image&quot;: null,
                &quot;members_count&quot;: 3,
                &quot;responsible&quot;: {
                    &quot;id&quot;: 10,
                    &quot;name&quot;: &quot;Ino Casablanca&quot;
                },
                &quot;members&quot;: [
                    {
                        &quot;id&quot;: 7,
                        &quot;name&quot;: &quot;Alice Durand&quot;,
                        &quot;email&quot;: &quot;alice.durand@example.com&quot;
                    },
                    {
                        &quot;id&quot;: 8,
                        &quot;name&quot;: &quot;Bob Douglas&quot;,
                        &quot;email&quot;: &quot;bob.douglas@example.com&quot;
                    },
                    {
                        &quot;id&quot;: 9,
                        &quot;name&quot;: &quot;Hugo Dialo&quot;,
                        &quot;email&quot;: &quot;hugo.dialo@example.com&quot;
                    }
                ]
            }
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-races--id--details" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-races--id--details"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-races--id--details"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-races--id--details" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-races--id--details">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-races--id--details" data-method="GET"
      data-path="api/races/{id}/details"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-races--id--details', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-races--id--details"
                    onclick="tryItOut('GETapi-races--id--details');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-races--id--details"
                    onclick="cancelTryOut('GETapi-races--id--details');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-races--id--details"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/races/{id}/details</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-races--id--details"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-races--id--details"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-races--id--details"
               value="1"
               data-component="url">
    <br>
<p>The ID of the race. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-races--raceId--results">GET api/races/{raceId}/results</h2>

<p>
</p>



<span id="example-requests-GETapi-races--raceId--results">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/races/1/results" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/races/1/results"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-races--raceId--results">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;TEA_ID&quot;: 3,
            &quot;USE_ID&quot;: 10,
            &quot;TEA_NAME&quot;: &quot;Arctic Mokeys&quot;,
            &quot;TEA_IMAGE&quot;: null,
            &quot;pivot&quot;: {
                &quot;RAC_ID&quot;: 1,
                &quot;TEA_ID&quot;: 3,
                &quot;TER_TIME&quot;: &quot;01:55:00&quot;,
                &quot;TER_IS_VALID&quot;: 1,
                &quot;TER_RACE_NUMBER&quot;: 402
            }
        },
        {
            &quot;TEA_ID&quot;: 1,
            &quot;USE_ID&quot;: 2,
            &quot;TEA_NAME&quot;: &quot;Lunatic&quot;,
            &quot;TEA_IMAGE&quot;: null,
            &quot;pivot&quot;: {
                &quot;RAC_ID&quot;: 1,
                &quot;TEA_ID&quot;: 1,
                &quot;TER_TIME&quot;: &quot;02:45:30&quot;,
                &quot;TER_IS_VALID&quot;: 1,
                &quot;TER_RACE_NUMBER&quot;: 101
            }
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-races--raceId--results" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-races--raceId--results"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-races--raceId--results"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-races--raceId--results" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-races--raceId--results">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-races--raceId--results" data-method="GET"
      data-path="api/races/{raceId}/results"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-races--raceId--results', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-races--raceId--results"
                    onclick="tryItOut('GETapi-races--raceId--results');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-races--raceId--results"
                    onclick="cancelTryOut('GETapi-races--raceId--results');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-races--raceId--results"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/races/{raceId}/results</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-races--raceId--results"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-races--raceId--results"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>raceId</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="raceId"                data-endpoint="GETapi-races--raceId--results"
               value="1"
               data-component="url">
    <br>
<p>Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-races--raceId--prices">GET api/races/{raceId}/prices</h2>

<p>
</p>



<span id="example-requests-GETapi-races--raceId--prices">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/races/1/prices" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/races/1/prices"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-races--raceId--prices">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;CAT_ID&quot;: 1,
            &quot;CAT_LABEL&quot;: &quot;Mineur&quot;,
            &quot;CAR_PRICE&quot;: 8
        },
        {
            &quot;CAT_ID&quot;: 2,
            &quot;CAT_LABEL&quot;: &quot;Majeur non licenci&eacute;&quot;,
            &quot;CAR_PRICE&quot;: 12
        },
        {
            &quot;CAT_ID&quot;: 3,
            &quot;CAT_LABEL&quot;: &quot;Licensi&eacute;&quot;,
            &quot;CAR_PRICE&quot;: 7
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-races--raceId--prices" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-races--raceId--prices"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-races--raceId--prices"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-races--raceId--prices" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-races--raceId--prices">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-races--raceId--prices" data-method="GET"
      data-path="api/races/{raceId}/prices"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-races--raceId--prices', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-races--raceId--prices"
                    onclick="tryItOut('GETapi-races--raceId--prices');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-races--raceId--prices"
                    onclick="cancelTryOut('GETapi-races--raceId--prices');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-races--raceId--prices"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/races/{raceId}/prices</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-races--raceId--prices"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-races--raceId--prices"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>raceId</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="raceId"                data-endpoint="GETapi-races--raceId--prices"
               value="1"
               data-component="url">
    <br>
<p>Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-clubs">GET api/clubs</h2>

<p>
</p>



<span id="example-requests-GETapi-clubs">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/clubs" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/clubs"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-clubs">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;CLU_ID&quot;: 1,
            &quot;USE_ID&quot;: 2,
            &quot;ADD_ID&quot;: 1,
            &quot;CLU_NAME&quot;: &quot;CO-DE&quot;,
            &quot;users_count&quot;: 5,
            &quot;address&quot;: {
                &quot;ADD_ID&quot;: 1,
                &quot;ADD_POSTAL_CODE&quot;: 50100,
                &quot;ADD_CITY&quot;: &quot;Cherbourg-en-Cotentin&quot;,
                &quot;ADD_STREET_NAME&quot;: &quot;Rue des Marins&quot;,
                &quot;ADD_STREET_NUMBER&quot;: &quot;12&quot;
            },
            &quot;user&quot;: {
                &quot;USE_ID&quot;: 2,
                &quot;ADD_ID&quot;: 2,
                &quot;CLU_ID&quot;: 1,
                &quot;USE_MAIL&quot;: &quot;marc.marquez@example.com&quot;,
                &quot;USE_NAME&quot;: &quot;Marc&quot;,
                &quot;USE_LAST_NAME&quot;: &quot;Marquez&quot;,
                &quot;USE_GENDER&quot;: &quot;Homme&quot;,
                &quot;USE_BIRTHDATE&quot;: &quot;1985-05-10T00:00:00.000000Z&quot;,
                &quot;USE_PHONE_NUMBER&quot;: 610000002,
                &quot;USE_LICENCE_NUMBER&quot;: 100002,
                &quot;USE_MEMBERSHIP_DATE&quot;: &quot;2022-01-01T00:00:00.000000Z&quot;,
                &quot;USE_VALIDITY&quot;: &quot;2020-11-12T00:00:00.000000Z&quot;
            }
        },
        {
            &quot;CLU_ID&quot;: 2,
            &quot;USE_ID&quot;: 3,
            &quot;ADD_ID&quot;: 3,
            &quot;CLU_NAME&quot;: &quot;L&#039;Embuscade&quot;,
            &quot;users_count&quot;: 5,
            &quot;address&quot;: {
                &quot;ADD_ID&quot;: 3,
                &quot;ADD_POSTAL_CODE&quot;: 14000,
                &quot;ADD_CITY&quot;: &quot;Caen&quot;,
                &quot;ADD_STREET_NAME&quot;: &quot;Avenue des Sports&quot;,
                &quot;ADD_STREET_NUMBER&quot;: &quot;7&quot;
            },
            &quot;user&quot;: {
                &quot;USE_ID&quot;: 3,
                &quot;ADD_ID&quot;: 3,
                &quot;CLU_ID&quot;: 2,
                &quot;USE_MAIL&quot;: &quot;fabio.quartararo@example.com&quot;,
                &quot;USE_NAME&quot;: &quot;Fabio&quot;,
                &quot;USE_LAST_NAME&quot;: &quot;Quartararo&quot;,
                &quot;USE_GENDER&quot;: &quot;Homme&quot;,
                &quot;USE_BIRTHDATE&quot;: &quot;1978-03-15T00:00:00.000000Z&quot;,
                &quot;USE_PHONE_NUMBER&quot;: 610000003,
                &quot;USE_LICENCE_NUMBER&quot;: 100003,
                &quot;USE_MEMBERSHIP_DATE&quot;: &quot;2022-01-01T00:00:00.000000Z&quot;,
                &quot;USE_VALIDITY&quot;: &quot;2021-01-13T00:00:00.000000Z&quot;
            }
        },
        {
            &quot;CLU_ID&quot;: 3,
            &quot;USE_ID&quot;: 13,
            &quot;ADD_ID&quot;: 5,
            &quot;CLU_NAME&quot;: &quot;CO AZIMUT 77&quot;,
            &quot;users_count&quot;: 3,
            &quot;address&quot;: {
                &quot;ADD_ID&quot;: 5,
                &quot;ADD_POSTAL_CODE&quot;: 75010,
                &quot;ADD_CITY&quot;: &quot;Paris&quot;,
                &quot;ADD_STREET_NAME&quot;: &quot;Rue de Paris&quot;,
                &quot;ADD_STREET_NUMBER&quot;: &quot;21&quot;
            },
            &quot;user&quot;: {
                &quot;USE_ID&quot;: 13,
                &quot;ADD_ID&quot;: 14,
                &quot;CLU_ID&quot;: null,
                &quot;USE_MAIL&quot;: &quot;yanis.enmieux@example.com&quot;,
                &quot;USE_NAME&quot;: &quot;Yanis&quot;,
                &quot;USE_LAST_NAME&quot;: &quot;En Mieux&quot;,
                &quot;USE_GENDER&quot;: &quot;Homme&quot;,
                &quot;USE_BIRTHDATE&quot;: &quot;1995-09-25T00:00:00.000000Z&quot;,
                &quot;USE_PHONE_NUMBER&quot;: 620000045,
                &quot;USE_LICENCE_NUMBER&quot;: 200016,
                &quot;USE_MEMBERSHIP_DATE&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
                &quot;USE_VALIDITY&quot;: &quot;2021-08-31T00:00:00.000000Z&quot;
            }
        },
        {
            &quot;CLU_ID&quot;: 4,
            &quot;USE_ID&quot;: 22,
            &quot;ADD_ID&quot;: 11,
            &quot;CLU_NAME&quot;: &quot;Club Existant Lugnier&quot;,
            &quot;users_count&quot;: 1,
            &quot;address&quot;: {
                &quot;ADD_ID&quot;: 11,
                &quot;ADD_POSTAL_CODE&quot;: 14100,
                &quot;ADD_CITY&quot;: &quot;Lisieux&quot;,
                &quot;ADD_STREET_NAME&quot;: &quot;Rue des Lilas&quot;,
                &quot;ADD_STREET_NUMBER&quot;: &quot;9&quot;
            },
            &quot;user&quot;: {
                &quot;USE_ID&quot;: 22,
                &quot;ADD_ID&quot;: 11,
                &quot;CLU_ID&quot;: 4,
                &quot;USE_MAIL&quot;: &quot;lugnier@example.com&quot;,
                &quot;USE_NAME&quot;: &quot;Marie&quot;,
                &quot;USE_LAST_NAME&quot;: &quot;Lugnier&quot;,
                &quot;USE_GENDER&quot;: &quot;Femme&quot;,
                &quot;USE_BIRTHDATE&quot;: &quot;1982-09-30T00:00:00.000000Z&quot;,
                &quot;USE_PHONE_NUMBER&quot;: 620000027,
                &quot;USE_LICENCE_NUMBER&quot;: 200027,
                &quot;USE_MEMBERSHIP_DATE&quot;: &quot;2022-01-01T00:00:00.000000Z&quot;,
                &quot;USE_VALIDITY&quot;: &quot;2024-12-31T00:00:00.000000Z&quot;
            }
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-clubs" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-clubs"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-clubs"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-clubs" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-clubs">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-clubs" data-method="GET"
      data-path="api/clubs"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-clubs', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-clubs"
                    onclick="tryItOut('GETapi-clubs');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-clubs"
                    onclick="cancelTryOut('GETapi-clubs');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-clubs"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/clubs</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-clubs"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-clubs"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-clubs--id-">GET api/clubs/{id}</h2>

<p>
</p>



<span id="example-requests-GETapi-clubs--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/clubs/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/clubs/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-clubs--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;CLU_ID&quot;: 1,
        &quot;USE_ID&quot;: 2,
        &quot;ADD_ID&quot;: 1,
        &quot;CLU_NAME&quot;: &quot;CO-DE&quot;
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-clubs--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-clubs--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-clubs--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-clubs--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-clubs--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-clubs--id-" data-method="GET"
      data-path="api/clubs/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-clubs--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-clubs--id-"
                    onclick="tryItOut('GETapi-clubs--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-clubs--id-"
                    onclick="cancelTryOut('GETapi-clubs--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-clubs--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/clubs/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-clubs--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-clubs--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-clubs--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the club. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-clubs--clubId--users">GET api/clubs/{clubId}/users</h2>

<p>
</p>



<span id="example-requests-GETapi-clubs--clubId--users">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/clubs/1/users" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/clubs/1/users"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-clubs--clubId--users">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;USE_ID&quot;: 2,
            &quot;ADD_ID&quot;: 2,
            &quot;CLU_ID&quot;: 1,
            &quot;USE_MAIL&quot;: &quot;marc.marquez@example.com&quot;,
            &quot;USE_NAME&quot;: &quot;Marc&quot;,
            &quot;USE_LAST_NAME&quot;: &quot;Marquez&quot;,
            &quot;USE_GENDER&quot;: &quot;Homme&quot;,
            &quot;USE_BIRTHDATE&quot;: &quot;1985-05-10T00:00:00.000000Z&quot;,
            &quot;USE_PHONE_NUMBER&quot;: 610000002,
            &quot;USE_LICENCE_NUMBER&quot;: 100002,
            &quot;USE_MEMBERSHIP_DATE&quot;: &quot;2022-01-01T00:00:00.000000Z&quot;,
            &quot;USE_VALIDITY&quot;: &quot;2020-11-12T00:00:00.000000Z&quot;
        },
        {
            &quot;USE_ID&quot;: 4,
            &quot;ADD_ID&quot;: 2,
            &quot;CLU_ID&quot;: 1,
            &quot;USE_MAIL&quot;: &quot;loane.kante@example.com&quot;,
            &quot;USE_NAME&quot;: &quot;Loane&quot;,
            &quot;USE_LAST_NAME&quot;: &quot;Kante&quot;,
            &quot;USE_GENDER&quot;: &quot;Femme&quot;,
            &quot;USE_BIRTHDATE&quot;: &quot;2000-05-10T00:00:00.000000Z&quot;,
            &quot;USE_PHONE_NUMBER&quot;: 610000004,
            &quot;USE_LICENCE_NUMBER&quot;: 100006,
            &quot;USE_MEMBERSHIP_DATE&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
            &quot;USE_VALIDITY&quot;: &quot;2021-06-30T00:00:00.000000Z&quot;
        },
        {
            &quot;USE_ID&quot;: 7,
            &quot;ADD_ID&quot;: 4,
            &quot;CLU_ID&quot;: 1,
            &quot;USE_MAIL&quot;: &quot;alice.durand@example.com&quot;,
            &quot;USE_NAME&quot;: &quot;Alice&quot;,
            &quot;USE_LAST_NAME&quot;: &quot;Durand&quot;,
            &quot;USE_GENDER&quot;: &quot;Femme&quot;,
            &quot;USE_BIRTHDATE&quot;: &quot;1990-06-01T00:00:00.000000Z&quot;,
            &quot;USE_PHONE_NUMBER&quot;: 620000004,
            &quot;USE_LICENCE_NUMBER&quot;: 200001,
            &quot;USE_MEMBERSHIP_DATE&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
            &quot;USE_VALIDITY&quot;: &quot;2022-02-16T00:00:00.000000Z&quot;
        },
        {
            &quot;USE_ID&quot;: 8,
            &quot;ADD_ID&quot;: 5,
            &quot;CLU_ID&quot;: 1,
            &quot;USE_MAIL&quot;: &quot;bob.douglas@example.com&quot;,
            &quot;USE_NAME&quot;: &quot;Bob&quot;,
            &quot;USE_LAST_NAME&quot;: &quot;Douglas&quot;,
            &quot;USE_GENDER&quot;: &quot;Homme&quot;,
            &quot;USE_BIRTHDATE&quot;: &quot;1992-02-01T00:00:00.000000Z&quot;,
            &quot;USE_PHONE_NUMBER&quot;: 620000005,
            &quot;USE_LICENCE_NUMBER&quot;: 200002,
            &quot;USE_MEMBERSHIP_DATE&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
            &quot;USE_VALIDITY&quot;: &quot;2022-02-28T00:00:00.000000Z&quot;
        },
        {
            &quot;USE_ID&quot;: 9,
            &quot;ADD_ID&quot;: 6,
            &quot;CLU_ID&quot;: 1,
            &quot;USE_MAIL&quot;: &quot;hugo.dialo@example.com&quot;,
            &quot;USE_NAME&quot;: &quot;Hugo&quot;,
            &quot;USE_LAST_NAME&quot;: &quot;Dialo&quot;,
            &quot;USE_GENDER&quot;: &quot;Homme&quot;,
            &quot;USE_BIRTHDATE&quot;: &quot;1995-09-15T00:00:00.000000Z&quot;,
            &quot;USE_PHONE_NUMBER&quot;: 620000006,
            &quot;USE_LICENCE_NUMBER&quot;: 200003,
            &quot;USE_MEMBERSHIP_DATE&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
            &quot;USE_VALIDITY&quot;: &quot;2021-03-09T00:00:00.000000Z&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-clubs--clubId--users" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-clubs--clubId--users"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-clubs--clubId--users"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-clubs--clubId--users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-clubs--clubId--users">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-clubs--clubId--users" data-method="GET"
      data-path="api/clubs/{clubId}/users"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-clubs--clubId--users', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-clubs--clubId--users"
                    onclick="tryItOut('GETapi-clubs--clubId--users');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-clubs--clubId--users"
                    onclick="cancelTryOut('GETapi-clubs--clubId--users');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-clubs--clubId--users"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/clubs/{clubId}/users</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-clubs--clubId--users"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-clubs--clubId--users"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>clubId</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="clubId"                data-endpoint="GETapi-clubs--clubId--users"
               value="1"
               data-component="url">
    <br>
<p>Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-users-free">GET api/users/free</h2>

<p>
</p>



<span id="example-requests-GETapi-users-free">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/users/free" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/users/free"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-users-free">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;USE_ID&quot;: 1,
            &quot;ADD_ID&quot;: 1,
            &quot;CLU_ID&quot;: null,
            &quot;USE_MAIL&quot;: &quot;admin.site@example.com&quot;,
            &quot;USE_NAME&quot;: &quot;Admin&quot;,
            &quot;USE_LAST_NAME&quot;: &quot;Site&quot;,
            &quot;USE_GENDER&quot;: &quot;Autre&quot;,
            &quot;USE_BIRTHDATE&quot;: &quot;1980-01-01T00:00:00.000000Z&quot;,
            &quot;USE_PHONE_NUMBER&quot;: 610000001,
            &quot;USE_LICENCE_NUMBER&quot;: null,
            &quot;USE_MEMBERSHIP_DATE&quot;: null,
            &quot;USE_VALIDITY&quot;: &quot;2020-01-01T00:00:00.000000Z&quot;
        },
        {
            &quot;USE_ID&quot;: 13,
            &quot;ADD_ID&quot;: 14,
            &quot;CLU_ID&quot;: null,
            &quot;USE_MAIL&quot;: &quot;yanis.enmieux@example.com&quot;,
            &quot;USE_NAME&quot;: &quot;Yanis&quot;,
            &quot;USE_LAST_NAME&quot;: &quot;En Mieux&quot;,
            &quot;USE_GENDER&quot;: &quot;Homme&quot;,
            &quot;USE_BIRTHDATE&quot;: &quot;1995-09-25T00:00:00.000000Z&quot;,
            &quot;USE_PHONE_NUMBER&quot;: 620000045,
            &quot;USE_LICENCE_NUMBER&quot;: 200016,
            &quot;USE_MEMBERSHIP_DATE&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
            &quot;USE_VALIDITY&quot;: &quot;2021-08-31T00:00:00.000000Z&quot;
        },
        {
            &quot;USE_ID&quot;: 16,
            &quot;ADD_ID&quot;: 12,
            &quot;CLU_ID&quot;: null,
            &quot;USE_MAIL&quot;: &quot;julie.garnier@example.com&quot;,
            &quot;USE_NAME&quot;: &quot;Julie&quot;,
            &quot;USE_LAST_NAME&quot;: &quot;Garnier&quot;,
            &quot;USE_GENDER&quot;: &quot;Femme&quot;,
            &quot;USE_BIRTHDATE&quot;: &quot;2005-08-15T00:00:00.000000Z&quot;,
            &quot;USE_PHONE_NUMBER&quot;: 620000022,
            &quot;USE_LICENCE_NUMBER&quot;: null,
            &quot;USE_MEMBERSHIP_DATE&quot;: null,
            &quot;USE_VALIDITY&quot;: null
        },
        {
            &quot;USE_ID&quot;: 17,
            &quot;ADD_ID&quot;: 13,
            &quot;CLU_ID&quot;: null,
            &quot;USE_MAIL&quot;: &quot;sylvian.delhoumi@example.com&quot;,
            &quot;USE_NAME&quot;: &quot;Sylvian&quot;,
            &quot;USE_LAST_NAME&quot;: &quot;Delhoumi&quot;,
            &quot;USE_GENDER&quot;: &quot;Homme&quot;,
            &quot;USE_BIRTHDATE&quot;: &quot;1985-11-10T00:00:00.000000Z&quot;,
            &quot;USE_PHONE_NUMBER&quot;: 620000023,
            &quot;USE_LICENCE_NUMBER&quot;: 200023,
            &quot;USE_MEMBERSHIP_DATE&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
            &quot;USE_VALIDITY&quot;: &quot;2024-12-31T00:00:00.000000Z&quot;
        },
        {
            &quot;USE_ID&quot;: 18,
            &quot;ADD_ID&quot;: 14,
            &quot;CLU_ID&quot;: null,
            &quot;USE_MAIL&quot;: &quot;anne@example.com&quot;,
            &quot;USE_NAME&quot;: &quot;Pierre&quot;,
            &quot;USE_LAST_NAME&quot;: &quot;Anne&quot;,
            &quot;USE_GENDER&quot;: &quot;Homme&quot;,
            &quot;USE_BIRTHDATE&quot;: &quot;1990-04-05T00:00:00.000000Z&quot;,
            &quot;USE_PHONE_NUMBER&quot;: 620000024,
            &quot;USE_LICENCE_NUMBER&quot;: 200024,
            &quot;USE_MEMBERSHIP_DATE&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
            &quot;USE_VALIDITY&quot;: &quot;2024-12-31T00:00:00.000000Z&quot;
        },
        {
            &quot;USE_ID&quot;: 19,
            &quot;ADD_ID&quot;: 15,
            &quot;CLU_ID&quot;: null,
            &quot;USE_MAIL&quot;: &quot;jacquier@example.com&quot;,
            &quot;USE_NAME&quot;: &quot;Thomas&quot;,
            &quot;USE_LAST_NAME&quot;: &quot;Jacquier&quot;,
            &quot;USE_GENDER&quot;: &quot;Homme&quot;,
            &quot;USE_BIRTHDATE&quot;: &quot;2015-01-01T00:00:00.000000Z&quot;,
            &quot;USE_PHONE_NUMBER&quot;: 620000025,
            &quot;USE_LICENCE_NUMBER&quot;: 200025,
            &quot;USE_MEMBERSHIP_DATE&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
            &quot;USE_VALIDITY&quot;: &quot;2024-12-31T00:00:00.000000Z&quot;
        },
        {
            &quot;USE_ID&quot;: 20,
            &quot;ADD_ID&quot;: 9,
            &quot;CLU_ID&quot;: null,
            &quot;USE_MAIL&quot;: &quot;coureur.sansclub@example.com&quot;,
            &quot;USE_NAME&quot;: &quot;Chloe&quot;,
            &quot;USE_LAST_NAME&quot;: &quot;Libre&quot;,
            &quot;USE_GENDER&quot;: &quot;Femme&quot;,
            &quot;USE_BIRTHDATE&quot;: &quot;1998-01-10T00:00:00.000000Z&quot;,
            &quot;USE_PHONE_NUMBER&quot;: 620000009,
            &quot;USE_LICENCE_NUMBER&quot;: null,
            &quot;USE_MEMBERSHIP_DATE&quot;: null,
            &quot;USE_VALIDITY&quot;: null
        },
        {
            &quot;USE_ID&quot;: 21,
            &quot;ADD_ID&quot;: 10,
            &quot;CLU_ID&quot;: null,
            &quot;USE_MAIL&quot;: &quot;lea.caron@example.com&quot;,
            &quot;USE_NAME&quot;: &quot;L&eacute;a&quot;,
            &quot;USE_LAST_NAME&quot;: &quot;Caron&quot;,
            &quot;USE_GENDER&quot;: &quot;Femme&quot;,
            &quot;USE_BIRTHDATE&quot;: &quot;1995-07-14T00:00:00.000000Z&quot;,
            &quot;USE_PHONE_NUMBER&quot;: 620000026,
            &quot;USE_LICENCE_NUMBER&quot;: 200026,
            &quot;USE_MEMBERSHIP_DATE&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
            &quot;USE_VALIDITY&quot;: &quot;2024-12-31T00:00:00.000000Z&quot;
        },
        {
            &quot;USE_ID&quot;: 23,
            &quot;ADD_ID&quot;: 12,
            &quot;CLU_ID&quot;: null,
            &quot;USE_MAIL&quot;: &quot;clara.dumont@example.com&quot;,
            &quot;USE_NAME&quot;: &quot;Clara&quot;,
            &quot;USE_LAST_NAME&quot;: &quot;Dumont&quot;,
            &quot;USE_GENDER&quot;: &quot;Femme&quot;,
            &quot;USE_BIRTHDATE&quot;: &quot;1988-12-05T00:00:00.000000Z&quot;,
            &quot;USE_PHONE_NUMBER&quot;: 620000028,
            &quot;USE_LICENCE_NUMBER&quot;: 200028,
            &quot;USE_MEMBERSHIP_DATE&quot;: &quot;2023-01-01T00:00:00.000000Z&quot;,
            &quot;USE_VALIDITY&quot;: &quot;2024-12-31T00:00:00.000000Z&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-users-free" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-users-free"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-users-free"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-users-free" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-users-free">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-users-free" data-method="GET"
      data-path="api/users/free"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-users-free', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-users-free"
                    onclick="tryItOut('GETapi-users-free');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-users-free"
                    onclick="cancelTryOut('GETapi-users-free');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-users-free"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/users/free</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-users-free"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-users-free"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTapi-raids">POST api/raids</h2>

<p>
</p>



<span id="example-requests-POSTapi-raids">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/raids" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"CLU_ID\": 16,
    \"ADD_ID\": 16,
    \"USE_ID\": 16,
    \"RAI_NAME\": \"n\",
    \"RAI_MAIL\": \"g\",
    \"RAI_PHONE_NUMBER\": \"zmiyvdljnikhwayk\",
    \"RAI_WEB_SITE\": \"c\",
    \"RAI_IMAGE\": \"m\",
    \"RAI_TIME_START\": \"2026-01-15T15:54:27\",
    \"RAI_TIME_END\": \"2052-02-08\",
    \"RAI_REGISTRATION_START\": \"2022-02-08\",
    \"RAI_REGISTRATION_END\": \"2052-02-08\",
    \"RAI_NB_RACES\": 22
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/raids"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "CLU_ID": 16,
    "ADD_ID": 16,
    "USE_ID": 16,
    "RAI_NAME": "n",
    "RAI_MAIL": "g",
    "RAI_PHONE_NUMBER": "zmiyvdljnikhwayk",
    "RAI_WEB_SITE": "c",
    "RAI_IMAGE": "m",
    "RAI_TIME_START": "2026-01-15T15:54:27",
    "RAI_TIME_END": "2052-02-08",
    "RAI_REGISTRATION_START": "2022-02-08",
    "RAI_REGISTRATION_END": "2052-02-08",
    "RAI_NB_RACES": 22
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-raids">
</span>
<span id="execution-results-POSTapi-raids" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-raids"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-raids"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-raids" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-raids">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-raids" data-method="POST"
      data-path="api/raids"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-raids', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-raids"
                    onclick="tryItOut('POSTapi-raids');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-raids"
                    onclick="cancelTryOut('POSTapi-raids');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-raids"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/raids</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-raids"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-raids"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>CLU_ID</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="CLU_ID"                data-endpoint="POSTapi-raids"
               value="16"
               data-component="body">
    <br>
<p>The <code>CLU_ID</code> of an existing record in the SAN_CLUBS table. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ADD_ID</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="ADD_ID"                data-endpoint="POSTapi-raids"
               value="16"
               data-component="body">
    <br>
<p>The <code>ADD_ID</code> of an existing record in the SAN_ADDRESSES table. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USE_ID</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="USE_ID"                data-endpoint="POSTapi-raids"
               value="16"
               data-component="body">
    <br>
<p>The <code>USE_ID</code> of an existing record in the SAN_USERS table. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAI_NAME</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAI_NAME"                data-endpoint="POSTapi-raids"
               value="n"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAI_MAIL</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAI_MAIL"                data-endpoint="POSTapi-raids"
               value="g"
               data-component="body">
    <br>
<p>This field is required when <code>RAI_PHONE_NUMBER</code> is not present. Must be a valid email address. Must not be greater than 255 characters. Example: <code>g</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAI_PHONE_NUMBER</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAI_PHONE_NUMBER"                data-endpoint="POSTapi-raids"
               value="zmiyvdljnikhwayk"
               data-component="body">
    <br>
<p>This field is required when <code>RAI_MAIL</code> is not present. Must not be greater than 20 characters. Example: <code>zmiyvdljnikhwayk</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAI_WEB_SITE</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAI_WEB_SITE"                data-endpoint="POSTapi-raids"
               value="c"
               data-component="body">
    <br>
<p>Must be a valid URL. Must not be greater than 255 characters. Example: <code>c</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAI_IMAGE</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAI_IMAGE"                data-endpoint="POSTapi-raids"
               value="m"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>m</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAI_TIME_START</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAI_TIME_START"                data-endpoint="POSTapi-raids"
               value="2026-01-15T15:54:27"
               data-component="body">
    <br>
<p>Must be a valid date. Example: <code>2026-01-15T15:54:27</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAI_TIME_END</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAI_TIME_END"                data-endpoint="POSTapi-raids"
               value="2052-02-08"
               data-component="body">
    <br>
<p>Must be a valid date. Must be a date after <code>RAI_TIME_START</code>. Example: <code>2052-02-08</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAI_REGISTRATION_START</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAI_REGISTRATION_START"                data-endpoint="POSTapi-raids"
               value="2022-02-08"
               data-component="body">
    <br>
<p>Must be a valid date. Must be a date before <code>RAI_TIME_START</code>. Example: <code>2022-02-08</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAI_REGISTRATION_END</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAI_REGISTRATION_END"                data-endpoint="POSTapi-raids"
               value="2052-02-08"
               data-component="body">
    <br>
<p>Must be a valid date. Must be a date before <code>RAI_TIME_START</code>. Must be a date after <code>RAI_REGISTRATION_START</code>. Example: <code>2052-02-08</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAI_NB_RACES</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAI_NB_RACES"                data-endpoint="POSTapi-raids"
               value="22"
               data-component="body">
    <br>
<p>Must be at least 1. Example: <code>22</code></p>
        </div>
        </form>

                    <h2 id="endpoints-PUTapi-raids--id-">PUT api/raids/{id}</h2>

<p>
</p>



<span id="example-requests-PUTapi-raids--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://localhost/api/raids/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"CLU_ID\": 16,
    \"ADD_ID\": 16,
    \"USE_ID\": 16,
    \"RAI_NAME\": \"n\",
    \"RAI_MAIL\": \"g\",
    \"RAI_PHONE_NUMBER\": \"zmiyvdljnikhwayk\",
    \"RAI_WEB_SITE\": \"c\",
    \"RAI_IMAGE\": \"m\",
    \"RAI_TIME_START\": \"2026-01-15T15:54:27\",
    \"RAI_TIME_END\": \"2052-02-08\",
    \"RAI_REGISTRATION_START\": \"2022-02-08\",
    \"RAI_REGISTRATION_END\": \"2052-02-08\",
    \"RAI_NB_RACES\": 22
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/raids/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "CLU_ID": 16,
    "ADD_ID": 16,
    "USE_ID": 16,
    "RAI_NAME": "n",
    "RAI_MAIL": "g",
    "RAI_PHONE_NUMBER": "zmiyvdljnikhwayk",
    "RAI_WEB_SITE": "c",
    "RAI_IMAGE": "m",
    "RAI_TIME_START": "2026-01-15T15:54:27",
    "RAI_TIME_END": "2052-02-08",
    "RAI_REGISTRATION_START": "2022-02-08",
    "RAI_REGISTRATION_END": "2052-02-08",
    "RAI_NB_RACES": 22
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-raids--id-">
</span>
<span id="execution-results-PUTapi-raids--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-raids--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-raids--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-raids--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-raids--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-raids--id-" data-method="PUT"
      data-path="api/raids/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-raids--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-raids--id-"
                    onclick="tryItOut('PUTapi-raids--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-raids--id-"
                    onclick="cancelTryOut('PUTapi-raids--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-raids--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/raids/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-raids--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-raids--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-raids--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the raid. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>CLU_ID</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="CLU_ID"                data-endpoint="PUTapi-raids--id-"
               value="16"
               data-component="body">
    <br>
<p>The <code>CLU_ID</code> of an existing record in the SAN_CLUBS table. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ADD_ID</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="ADD_ID"                data-endpoint="PUTapi-raids--id-"
               value="16"
               data-component="body">
    <br>
<p>The <code>ADD_ID</code> of an existing record in the SAN_ADDRESSES table. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USE_ID</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="USE_ID"                data-endpoint="PUTapi-raids--id-"
               value="16"
               data-component="body">
    <br>
<p>The <code>USE_ID</code> of an existing record in the SAN_USERS table. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAI_NAME</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAI_NAME"                data-endpoint="PUTapi-raids--id-"
               value="n"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAI_MAIL</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAI_MAIL"                data-endpoint="PUTapi-raids--id-"
               value="g"
               data-component="body">
    <br>
<p>This field is required when <code>RAI_PHONE_NUMBER</code> is not present. Must be a valid email address. Must not be greater than 255 characters. Example: <code>g</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAI_PHONE_NUMBER</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAI_PHONE_NUMBER"                data-endpoint="PUTapi-raids--id-"
               value="zmiyvdljnikhwayk"
               data-component="body">
    <br>
<p>This field is required when <code>RAI_MAIL</code> is not present. Must not be greater than 20 characters. Example: <code>zmiyvdljnikhwayk</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAI_WEB_SITE</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAI_WEB_SITE"                data-endpoint="PUTapi-raids--id-"
               value="c"
               data-component="body">
    <br>
<p>Must be a valid URL. Must not be greater than 255 characters. Example: <code>c</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAI_IMAGE</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAI_IMAGE"                data-endpoint="PUTapi-raids--id-"
               value="m"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>m</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAI_TIME_START</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAI_TIME_START"                data-endpoint="PUTapi-raids--id-"
               value="2026-01-15T15:54:27"
               data-component="body">
    <br>
<p>Must be a valid date. Example: <code>2026-01-15T15:54:27</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAI_TIME_END</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAI_TIME_END"                data-endpoint="PUTapi-raids--id-"
               value="2052-02-08"
               data-component="body">
    <br>
<p>Must be a valid date. Must be a date after <code>RAI_TIME_START</code>. Example: <code>2052-02-08</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAI_REGISTRATION_START</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAI_REGISTRATION_START"                data-endpoint="PUTapi-raids--id-"
               value="2022-02-08"
               data-component="body">
    <br>
<p>Must be a valid date. Must be a date before <code>RAI_TIME_START</code>. Example: <code>2022-02-08</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAI_REGISTRATION_END</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAI_REGISTRATION_END"                data-endpoint="PUTapi-raids--id-"
               value="2052-02-08"
               data-component="body">
    <br>
<p>Must be a valid date. Must be a date before <code>RAI_TIME_START</code>. Must be a date after <code>RAI_REGISTRATION_START</code>. Example: <code>2052-02-08</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAI_NB_RACES</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAI_NB_RACES"                data-endpoint="PUTapi-raids--id-"
               value="22"
               data-component="body">
    <br>
<p>Must be at least 1. Example: <code>22</code></p>
        </div>
        </form>

                    <h2 id="endpoints-DELETEapi-raids--id-">DELETE api/raids/{id}</h2>

<p>
</p>



<span id="example-requests-DELETEapi-raids--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost/api/raids/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/raids/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-raids--id-">
</span>
<span id="execution-results-DELETEapi-raids--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-raids--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-raids--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-raids--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-raids--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-raids--id-" data-method="DELETE"
      data-path="api/raids/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-raids--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-raids--id-"
                    onclick="tryItOut('DELETEapi-raids--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-raids--id-"
                    onclick="cancelTryOut('DELETEapi-raids--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-raids--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/raids/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-raids--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-raids--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-raids--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the raid. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-POSTapi-races">POST api/races</h2>

<p>
</p>



<span id="example-requests-POSTapi-races">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/races" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"USE_ID\": 16,
    \"RAI_ID\": 16,
    \"RAC_NAME\": \"n\",
    \"RAC_TIME_START\": \"2026-01-15T15:54:27\",
    \"RAC_TIME_END\": \"2052-02-08\",
    \"RAC_GENDER\": \"Mixte\",
    \"RAC_TYPE\": \"n\",
    \"RAC_DIFFICULTY\": \"g\",
    \"RAC_MIN_PARTICIPANTS\": 12,
    \"RAC_MAX_PARTICIPANTS\": 77,
    \"RAC_MIN_TEAMS\": 8,
    \"RAC_MAX_TEAMS\": 76,
    \"RAC_MAX_TEAM_MEMBERS\": 60,
    \"RAC_AGE_MIN\": 42,
    \"RAC_AGE_MIDDLE\": 37,
    \"RAC_AGE_MAX\": 9,
    \"RAC_CHIP_MANDATORY\": \"0\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/races"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "USE_ID": 16,
    "RAI_ID": 16,
    "RAC_NAME": "n",
    "RAC_TIME_START": "2026-01-15T15:54:27",
    "RAC_TIME_END": "2052-02-08",
    "RAC_GENDER": "Mixte",
    "RAC_TYPE": "n",
    "RAC_DIFFICULTY": "g",
    "RAC_MIN_PARTICIPANTS": 12,
    "RAC_MAX_PARTICIPANTS": 77,
    "RAC_MIN_TEAMS": 8,
    "RAC_MAX_TEAMS": 76,
    "RAC_MAX_TEAM_MEMBERS": 60,
    "RAC_AGE_MIN": 42,
    "RAC_AGE_MIDDLE": 37,
    "RAC_AGE_MAX": 9,
    "RAC_CHIP_MANDATORY": "0"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-races">
</span>
<span id="execution-results-POSTapi-races" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-races"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-races"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-races" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-races">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-races" data-method="POST"
      data-path="api/races"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-races', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-races"
                    onclick="tryItOut('POSTapi-races');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-races"
                    onclick="cancelTryOut('POSTapi-races');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-races"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/races</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-races"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-races"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USE_ID</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="USE_ID"                data-endpoint="POSTapi-races"
               value="16"
               data-component="body">
    <br>
<p>The <code>USE_ID</code> of an existing record in the SAN_USERS table. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAI_ID</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAI_ID"                data-endpoint="POSTapi-races"
               value="16"
               data-component="body">
    <br>
<p>The <code>RAI_ID</code> of an existing record in the SAN_RAIDS table. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_NAME</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAC_NAME"                data-endpoint="POSTapi-races"
               value="n"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_TIME_START</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAC_TIME_START"                data-endpoint="POSTapi-races"
               value="2026-01-15T15:54:27"
               data-component="body">
    <br>
<p>Must be a valid date. Example: <code>2026-01-15T15:54:27</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_TIME_END</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAC_TIME_END"                data-endpoint="POSTapi-races"
               value="2052-02-08"
               data-component="body">
    <br>
<p>Must be a valid date. Must be a date after or equal to <code>RAC_TIME_START</code>. Example: <code>2052-02-08</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_GENDER</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAC_GENDER"                data-endpoint="POSTapi-races"
               value="Mixte"
               data-component="body">
    <br>
<p>Example: <code>Mixte</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>Homme</code></li> <li><code>Femme</code></li> <li><code>Mixte</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_TYPE</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAC_TYPE"                data-endpoint="POSTapi-races"
               value="n"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_DIFFICULTY</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAC_DIFFICULTY"                data-endpoint="POSTapi-races"
               value="g"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>g</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_MIN_PARTICIPANTS</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAC_MIN_PARTICIPANTS"                data-endpoint="POSTapi-races"
               value="12"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>12</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_MAX_PARTICIPANTS</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAC_MAX_PARTICIPANTS"                data-endpoint="POSTapi-races"
               value="77"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>77</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_MIN_TEAMS</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAC_MIN_TEAMS"                data-endpoint="POSTapi-races"
               value="8"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>8</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_MAX_TEAMS</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAC_MAX_TEAMS"                data-endpoint="POSTapi-races"
               value="76"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>76</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_MAX_TEAM_MEMBERS</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAC_MAX_TEAM_MEMBERS"                data-endpoint="POSTapi-races"
               value="60"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>60</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_AGE_MIN</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAC_AGE_MIN"                data-endpoint="POSTapi-races"
               value="42"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>42</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_AGE_MIDDLE</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAC_AGE_MIDDLE"                data-endpoint="POSTapi-races"
               value="37"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>37</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_AGE_MAX</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAC_AGE_MAX"                data-endpoint="POSTapi-races"
               value="9"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>9</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_CHIP_MANDATORY</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAC_CHIP_MANDATORY"                data-endpoint="POSTapi-races"
               value="0"
               data-component="body">
    <br>
<p>Example: <code>0</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>0</code></li> <li><code>1</code></li></ul>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-races-with-prices">POST api/races/with-prices</h2>

<p>
</p>



<span id="example-requests-POSTapi-races-with-prices">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/races/with-prices" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"USE_ID\": 16,
    \"RAI_ID\": 16,
    \"RAC_NAME\": \"n\",
    \"RAC_TIME_START\": \"2026-01-15T15:54:27\",
    \"RAC_TIME_END\": \"2052-02-08\",
    \"RAC_GENDER\": \"Mixte\",
    \"RAC_TYPE\": \"n\",
    \"RAC_DIFFICULTY\": \"g\",
    \"RAC_MIN_PARTICIPANTS\": 12,
    \"RAC_MAX_PARTICIPANTS\": 77,
    \"RAC_MIN_TEAMS\": 8,
    \"RAC_MAX_TEAMS\": 76,
    \"RAC_MAX_TEAM_MEMBERS\": 60,
    \"RAC_AGE_MIN\": 42,
    \"RAC_AGE_MIDDLE\": 37,
    \"RAC_AGE_MAX\": 9,
    \"RAC_CHIP_MANDATORY\": \"1\",
    \"CAT_1_PRICE\": 52,
    \"CAT_2_PRICE\": 8,
    \"CAT_3_PRICE\": 75
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/races/with-prices"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "USE_ID": 16,
    "RAI_ID": 16,
    "RAC_NAME": "n",
    "RAC_TIME_START": "2026-01-15T15:54:27",
    "RAC_TIME_END": "2052-02-08",
    "RAC_GENDER": "Mixte",
    "RAC_TYPE": "n",
    "RAC_DIFFICULTY": "g",
    "RAC_MIN_PARTICIPANTS": 12,
    "RAC_MAX_PARTICIPANTS": 77,
    "RAC_MIN_TEAMS": 8,
    "RAC_MAX_TEAMS": 76,
    "RAC_MAX_TEAM_MEMBERS": 60,
    "RAC_AGE_MIN": 42,
    "RAC_AGE_MIDDLE": 37,
    "RAC_AGE_MAX": 9,
    "RAC_CHIP_MANDATORY": "1",
    "CAT_1_PRICE": 52,
    "CAT_2_PRICE": 8,
    "CAT_3_PRICE": 75
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-races-with-prices">
</span>
<span id="execution-results-POSTapi-races-with-prices" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-races-with-prices"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-races-with-prices"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-races-with-prices" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-races-with-prices">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-races-with-prices" data-method="POST"
      data-path="api/races/with-prices"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-races-with-prices', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-races-with-prices"
                    onclick="tryItOut('POSTapi-races-with-prices');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-races-with-prices"
                    onclick="cancelTryOut('POSTapi-races-with-prices');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-races-with-prices"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/races/with-prices</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-races-with-prices"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-races-with-prices"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USE_ID</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="USE_ID"                data-endpoint="POSTapi-races-with-prices"
               value="16"
               data-component="body">
    <br>
<p>The <code>USE_ID</code> of an existing record in the SAN_USERS table. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAI_ID</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAI_ID"                data-endpoint="POSTapi-races-with-prices"
               value="16"
               data-component="body">
    <br>
<p>The <code>RAI_ID</code> of an existing record in the SAN_RAIDS table. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_NAME</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAC_NAME"                data-endpoint="POSTapi-races-with-prices"
               value="n"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_TIME_START</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAC_TIME_START"                data-endpoint="POSTapi-races-with-prices"
               value="2026-01-15T15:54:27"
               data-component="body">
    <br>
<p>Must be a valid date. Example: <code>2026-01-15T15:54:27</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_TIME_END</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAC_TIME_END"                data-endpoint="POSTapi-races-with-prices"
               value="2052-02-08"
               data-component="body">
    <br>
<p>Must be a valid date. Must be a date after or equal to <code>RAC_TIME_START</code>. Example: <code>2052-02-08</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_GENDER</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAC_GENDER"                data-endpoint="POSTapi-races-with-prices"
               value="Mixte"
               data-component="body">
    <br>
<p>Example: <code>Mixte</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>Homme</code></li> <li><code>Femme</code></li> <li><code>Mixte</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_TYPE</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAC_TYPE"                data-endpoint="POSTapi-races-with-prices"
               value="n"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_DIFFICULTY</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAC_DIFFICULTY"                data-endpoint="POSTapi-races-with-prices"
               value="g"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>g</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_MIN_PARTICIPANTS</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAC_MIN_PARTICIPANTS"                data-endpoint="POSTapi-races-with-prices"
               value="12"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>12</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_MAX_PARTICIPANTS</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAC_MAX_PARTICIPANTS"                data-endpoint="POSTapi-races-with-prices"
               value="77"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>77</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_MIN_TEAMS</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAC_MIN_TEAMS"                data-endpoint="POSTapi-races-with-prices"
               value="8"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>8</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_MAX_TEAMS</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAC_MAX_TEAMS"                data-endpoint="POSTapi-races-with-prices"
               value="76"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>76</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_MAX_TEAM_MEMBERS</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAC_MAX_TEAM_MEMBERS"                data-endpoint="POSTapi-races-with-prices"
               value="60"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>60</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_AGE_MIN</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAC_AGE_MIN"                data-endpoint="POSTapi-races-with-prices"
               value="42"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>42</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_AGE_MIDDLE</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAC_AGE_MIDDLE"                data-endpoint="POSTapi-races-with-prices"
               value="37"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>37</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_AGE_MAX</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAC_AGE_MAX"                data-endpoint="POSTapi-races-with-prices"
               value="9"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>9</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_CHIP_MANDATORY</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAC_CHIP_MANDATORY"                data-endpoint="POSTapi-races-with-prices"
               value="1"
               data-component="body">
    <br>
<p>Example: <code>1</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>0</code></li> <li><code>1</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>CAT_1_PRICE</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="CAT_1_PRICE"                data-endpoint="POSTapi-races-with-prices"
               value="52"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>52</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>CAT_2_PRICE</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="CAT_2_PRICE"                data-endpoint="POSTapi-races-with-prices"
               value="8"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>8</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>CAT_3_PRICE</code></b>&nbsp;&nbsp;
<small>number</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="CAT_3_PRICE"                data-endpoint="POSTapi-races-with-prices"
               value="75"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>75</code></p>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-races--raceId--team-results">POST api/races/{raceId}/team-results</h2>

<p>
</p>



<span id="example-requests-POSTapi-races--raceId--team-results">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/races/1/team-results" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"TEA_ID\": 16,
    \"TER_TIME\": \"15:54:27\",
    \"TER_IS_VALID\": \"1\",
    \"TER_RACE_NUMBER\": 22
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/races/1/team-results"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "TEA_ID": 16,
    "TER_TIME": "15:54:27",
    "TER_IS_VALID": "1",
    "TER_RACE_NUMBER": 22
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-races--raceId--team-results">
</span>
<span id="execution-results-POSTapi-races--raceId--team-results" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-races--raceId--team-results"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-races--raceId--team-results"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-races--raceId--team-results" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-races--raceId--team-results">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-races--raceId--team-results" data-method="POST"
      data-path="api/races/{raceId}/team-results"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-races--raceId--team-results', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-races--raceId--team-results"
                    onclick="tryItOut('POSTapi-races--raceId--team-results');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-races--raceId--team-results"
                    onclick="cancelTryOut('POSTapi-races--raceId--team-results');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-races--raceId--team-results"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/races/{raceId}/team-results</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-races--raceId--team-results"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-races--raceId--team-results"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>raceId</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="raceId"                data-endpoint="POSTapi-races--raceId--team-results"
               value="1"
               data-component="url">
    <br>
<p>Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>TEA_ID</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="TEA_ID"                data-endpoint="POSTapi-races--raceId--team-results"
               value="16"
               data-component="body">
    <br>
<p>The <code>TEA_ID</code> of an existing record in the SAN_TEAMS table. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>TER_TIME</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="TER_TIME"                data-endpoint="POSTapi-races--raceId--team-results"
               value="15:54:27"
               data-component="body">
    <br>
<p>Must be a valid date in the format <code>H:i:s</code>. Example: <code>15:54:27</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>TER_IS_VALID</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="TER_IS_VALID"                data-endpoint="POSTapi-races--raceId--team-results"
               value="1"
               data-component="body">
    <br>
<p>Example: <code>1</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>0</code></li> <li><code>1</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>TER_RACE_NUMBER</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="TER_RACE_NUMBER"                data-endpoint="POSTapi-races--raceId--team-results"
               value="22"
               data-component="body">
    <br>
<p>Must be at least 1. Example: <code>22</code></p>
        </div>
        </form>

                    <h2 id="endpoints-PUTapi-races--id-">PUT api/races/{id}</h2>

<p>
</p>



<span id="example-requests-PUTapi-races--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://localhost/api/races/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"RAI_ID\": 16,
    \"RAC_NAME\": \"n\",
    \"RAC_TIME_START\": \"2026-01-15T15:54:27\",
    \"RAC_TIME_END\": \"2052-02-08\",
    \"RAC_GENDER\": \"Femme\",
    \"RAC_TYPE\": \"n\",
    \"RAC_DIFFICULTY\": \"g\",
    \"RAC_MIN_PARTICIPANTS\": 12,
    \"RAC_MAX_PARTICIPANTS\": 77,
    \"RAC_MIN_TEAMS\": 8,
    \"RAC_MAX_TEAMS\": 76,
    \"RAC_MAX_TEAM_MEMBERS\": 60,
    \"RAC_AGE_MIN\": 42,
    \"RAC_AGE_MIDDLE\": 37,
    \"RAC_AGE_MAX\": 9,
    \"RAC_CHIP_MANDATORY\": \"1\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/races/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "RAI_ID": 16,
    "RAC_NAME": "n",
    "RAC_TIME_START": "2026-01-15T15:54:27",
    "RAC_TIME_END": "2052-02-08",
    "RAC_GENDER": "Femme",
    "RAC_TYPE": "n",
    "RAC_DIFFICULTY": "g",
    "RAC_MIN_PARTICIPANTS": 12,
    "RAC_MAX_PARTICIPANTS": 77,
    "RAC_MIN_TEAMS": 8,
    "RAC_MAX_TEAMS": 76,
    "RAC_MAX_TEAM_MEMBERS": 60,
    "RAC_AGE_MIN": 42,
    "RAC_AGE_MIDDLE": 37,
    "RAC_AGE_MAX": 9,
    "RAC_CHIP_MANDATORY": "1"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-races--id-">
</span>
<span id="execution-results-PUTapi-races--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-races--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-races--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-races--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-races--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-races--id-" data-method="PUT"
      data-path="api/races/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-races--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-races--id-"
                    onclick="tryItOut('PUTapi-races--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-races--id-"
                    onclick="cancelTryOut('PUTapi-races--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-races--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/races/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-races--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-races--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-races--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the race. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAI_ID</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAI_ID"                data-endpoint="PUTapi-races--id-"
               value="16"
               data-component="body">
    <br>
<p>The <code>RAI_ID</code> of an existing record in the SAN_RAIDS table. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_NAME</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAC_NAME"                data-endpoint="PUTapi-races--id-"
               value="n"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_TIME_START</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAC_TIME_START"                data-endpoint="PUTapi-races--id-"
               value="2026-01-15T15:54:27"
               data-component="body">
    <br>
<p>Must be a valid date. Example: <code>2026-01-15T15:54:27</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_TIME_END</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAC_TIME_END"                data-endpoint="PUTapi-races--id-"
               value="2052-02-08"
               data-component="body">
    <br>
<p>Must be a valid date. Must be a date after or equal to <code>RAC_TIME_START</code>. Example: <code>2052-02-08</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_GENDER</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAC_GENDER"                data-endpoint="PUTapi-races--id-"
               value="Femme"
               data-component="body">
    <br>
<p>Example: <code>Femme</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>Homme</code></li> <li><code>Femme</code></li> <li><code>Mixte</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_TYPE</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAC_TYPE"                data-endpoint="PUTapi-races--id-"
               value="n"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_DIFFICULTY</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="RAC_DIFFICULTY"                data-endpoint="PUTapi-races--id-"
               value="g"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>g</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_MIN_PARTICIPANTS</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAC_MIN_PARTICIPANTS"                data-endpoint="PUTapi-races--id-"
               value="12"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>12</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_MAX_PARTICIPANTS</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAC_MAX_PARTICIPANTS"                data-endpoint="PUTapi-races--id-"
               value="77"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>77</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_MIN_TEAMS</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAC_MIN_TEAMS"                data-endpoint="PUTapi-races--id-"
               value="8"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>8</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_MAX_TEAMS</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAC_MAX_TEAMS"                data-endpoint="PUTapi-races--id-"
               value="76"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>76</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_MAX_TEAM_MEMBERS</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAC_MAX_TEAM_MEMBERS"                data-endpoint="PUTapi-races--id-"
               value="60"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>60</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_AGE_MIN</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAC_AGE_MIN"                data-endpoint="PUTapi-races--id-"
               value="42"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>42</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_AGE_MIDDLE</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAC_AGE_MIDDLE"                data-endpoint="PUTapi-races--id-"
               value="37"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>37</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_AGE_MAX</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAC_AGE_MAX"                data-endpoint="PUTapi-races--id-"
               value="9"
               data-component="body">
    <br>
<p>Must be at least 0. Example: <code>9</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_CHIP_MANDATORY</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAC_CHIP_MANDATORY"                data-endpoint="PUTapi-races--id-"
               value="1"
               data-component="body">
    <br>
<p>Example: <code>1</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>0</code></li> <li><code>1</code></li></ul>
        </div>
        </form>

                    <h2 id="endpoints-DELETEapi-races--id-">DELETE api/races/{id}</h2>

<p>
</p>



<span id="example-requests-DELETEapi-races--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost/api/races/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/races/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-races--id-">
</span>
<span id="execution-results-DELETEapi-races--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-races--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-races--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-races--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-races--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-races--id-" data-method="DELETE"
      data-path="api/races/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-races--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-races--id-"
                    onclick="tryItOut('DELETEapi-races--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-races--id-"
                    onclick="cancelTryOut('DELETEapi-races--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-races--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/races/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-races--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-races--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-races--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the race. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-races--raceId--teams">GET api/races/{raceId}/teams</h2>

<p>
</p>



<span id="example-requests-GETapi-races--raceId--teams">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/races/1/teams" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/races/1/teams"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-races--raceId--teams">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-races--raceId--teams" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-races--raceId--teams"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-races--raceId--teams"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-races--raceId--teams" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-races--raceId--teams">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-races--raceId--teams" data-method="GET"
      data-path="api/races/{raceId}/teams"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-races--raceId--teams', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-races--raceId--teams"
                    onclick="tryItOut('GETapi-races--raceId--teams');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-races--raceId--teams"
                    onclick="cancelTryOut('GETapi-races--raceId--teams');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-races--raceId--teams"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/races/{raceId}/teams</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-races--raceId--teams"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-races--raceId--teams"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>raceId</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="raceId"                data-endpoint="GETapi-races--raceId--teams"
               value="1"
               data-component="url">
    <br>
<p>Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-user">GET api/user</h2>

<p>
</p>



<span id="example-requests-GETapi-user">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/user" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/user"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-user">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-user" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-user"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-user"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-user" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-user">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-user" data-method="GET"
      data-path="api/user"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-user', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-user"
                    onclick="tryItOut('GETapi-user');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-user"
                    onclick="cancelTryOut('GETapi-user');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-user"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/user</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-user"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-user"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-user-is-admin">GET api/user/is-admin</h2>

<p>
</p>



<span id="example-requests-GETapi-user-is-admin">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/user/is-admin" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/user/is-admin"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-user-is-admin">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-user-is-admin" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-user-is-admin"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-user-is-admin"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-user-is-admin" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-user-is-admin">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-user-is-admin" data-method="GET"
      data-path="api/user/is-admin"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-user-is-admin', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-user-is-admin"
                    onclick="tryItOut('GETapi-user-is-admin');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-user-is-admin"
                    onclick="cancelTryOut('GETapi-user-is-admin');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-user-is-admin"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/user/is-admin</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-user-is-admin"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-user-is-admin"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-user-stats--id-">GET api/user/stats/{id}</h2>

<p>
</p>



<span id="example-requests-GETapi-user-stats--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/user/stats/564" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/user/stats/564"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-user-stats--id-">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-user-stats--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-user-stats--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-user-stats--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-user-stats--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-user-stats--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-user-stats--id-" data-method="GET"
      data-path="api/user/stats/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-user-stats--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-user-stats--id-"
                    onclick="tryItOut('GETapi-user-stats--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-user-stats--id-"
                    onclick="cancelTryOut('GETapi-user-stats--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-user-stats--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/user/stats/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-user-stats--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-user-stats--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="GETapi-user-stats--id-"
               value="564"
               data-component="url">
    <br>
<p>The ID of the stat. Example: <code>564</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-user-history--id-">GET api/user/history/{id}</h2>

<p>
</p>



<span id="example-requests-GETapi-user-history--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/user/history/564" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/user/history/564"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-user-history--id-">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-user-history--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-user-history--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-user-history--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-user-history--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-user-history--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-user-history--id-" data-method="GET"
      data-path="api/user/history/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-user-history--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-user-history--id-"
                    onclick="tryItOut('GETapi-user-history--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-user-history--id-"
                    onclick="cancelTryOut('GETapi-user-history--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-user-history--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/user/history/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-user-history--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-user-history--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="GETapi-user-history--id-"
               value="564"
               data-component="url">
    <br>
<p>The ID of the history. Example: <code>564</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-users">GET api/users</h2>

<p>
</p>



<span id="example-requests-GETapi-users">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/users" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/users"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-users">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-users" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-users"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-users"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-users">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-users" data-method="GET"
      data-path="api/users"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-users', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-users"
                    onclick="tryItOut('GETapi-users');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-users"
                    onclick="cancelTryOut('GETapi-users');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-users"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/users</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-users"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-users"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-GETapi-users--id-">GET api/users/{id}</h2>

<p>
</p>



<span id="example-requests-GETapi-users--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/users/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/users/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-users--id-">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-users--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-users--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-users--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-users--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-users--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-users--id-" data-method="GET"
      data-path="api/users/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-users--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-users--id-"
                    onclick="tryItOut('GETapi-users--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-users--id-"
                    onclick="cancelTryOut('GETapi-users--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-users--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/users/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-users--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-users--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-users--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the user. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-PUTapi-users--id-">PUT api/users/{id}</h2>

<p>
</p>



<span id="example-requests-PUTapi-users--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://localhost/api/users/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"USE_PASSWORD\": \"bngzmiyvdljnikhwaykcmyuwpw\",
    \"USE_NAME\": \"l\",
    \"USE_LAST_NAME\": \"v\",
    \"USE_GENDER\": \"Femme\",
    \"USE_BIRTHDATE\": \"2026-01-15T15:54:27\",
    \"USE_PHONE_NUMBER\": 16,
    \"USE_LICENCE_NUMBER\": 16,
    \"USE_MEMBERSHIP_DATE\": \"2026-01-15T15:54:27\",
    \"USE_VALIDITY\": \"2026-01-15T15:54:27\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/users/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "USE_PASSWORD": "bngzmiyvdljnikhwaykcmyuwpw",
    "USE_NAME": "l",
    "USE_LAST_NAME": "v",
    "USE_GENDER": "Femme",
    "USE_BIRTHDATE": "2026-01-15T15:54:27",
    "USE_PHONE_NUMBER": 16,
    "USE_LICENCE_NUMBER": 16,
    "USE_MEMBERSHIP_DATE": "2026-01-15T15:54:27",
    "USE_VALIDITY": "2026-01-15T15:54:27"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-users--id-">
</span>
<span id="execution-results-PUTapi-users--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-users--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-users--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-users--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-users--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-users--id-" data-method="PUT"
      data-path="api/users/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-users--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-users--id-"
                    onclick="tryItOut('PUTapi-users--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-users--id-"
                    onclick="cancelTryOut('PUTapi-users--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-users--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/users/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-users--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-users--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-users--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the user. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USE_MAIL</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="USE_MAIL"                data-endpoint="PUTapi-users--id-"
               value=""
               data-component="body">
    <br>

        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USE_PASSWORD</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="USE_PASSWORD"                data-endpoint="PUTapi-users--id-"
               value="bngzmiyvdljnikhwaykcmyuwpw"
               data-component="body">
    <br>
<p>Must be at least 8 characters. Example: <code>bngzmiyvdljnikhwaykcmyuwpw</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USE_NAME</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="USE_NAME"                data-endpoint="PUTapi-users--id-"
               value="l"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>l</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USE_LAST_NAME</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="USE_LAST_NAME"                data-endpoint="PUTapi-users--id-"
               value="v"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>v</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USE_GENDER</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="USE_GENDER"                data-endpoint="PUTapi-users--id-"
               value="Femme"
               data-component="body">
    <br>
<p>Example: <code>Femme</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>Homme</code></li> <li><code>Femme</code></li> <li><code>Autre</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USE_BIRTHDATE</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="USE_BIRTHDATE"                data-endpoint="PUTapi-users--id-"
               value="2026-01-15T15:54:27"
               data-component="body">
    <br>
<p>Must be a valid date. Example: <code>2026-01-15T15:54:27</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USE_PHONE_NUMBER</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="USE_PHONE_NUMBER"                data-endpoint="PUTapi-users--id-"
               value="16"
               data-component="body">
    <br>
<p>Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USE_LICENCE_NUMBER</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="USE_LICENCE_NUMBER"                data-endpoint="PUTapi-users--id-"
               value="16"
               data-component="body">
    <br>
<p>Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USE_MEMBERSHIP_DATE</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="USE_MEMBERSHIP_DATE"                data-endpoint="PUTapi-users--id-"
               value="2026-01-15T15:54:27"
               data-component="body">
    <br>
<p>Must be a valid date. Example: <code>2026-01-15T15:54:27</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USE_VALIDITY</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="USE_VALIDITY"                data-endpoint="PUTapi-users--id-"
               value="2026-01-15T15:54:27"
               data-component="body">
    <br>
<p>Must be a valid date. Example: <code>2026-01-15T15:54:27</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>CLU_ID</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="CLU_ID"                data-endpoint="PUTapi-users--id-"
               value=""
               data-component="body">
    <br>
<p>The <code>CLU_ID</code> of an existing record in the SAN_CLUBS table.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ADD_ID</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ADD_ID"                data-endpoint="PUTapi-users--id-"
               value=""
               data-component="body">
    <br>
<p>The <code>ADD_ID</code> of an existing record in the SAN_ADDRESSES table.</p>
        </div>
        </form>

                    <h2 id="endpoints-DELETEapi-users--id-">DELETE api/users/{id}</h2>

<p>
</p>



<span id="example-requests-DELETEapi-users--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost/api/users/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/users/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-users--id-">
</span>
<span id="execution-results-DELETEapi-users--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-users--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-users--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-users--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-users--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-users--id-" data-method="DELETE"
      data-path="api/users/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-users--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-users--id-"
                    onclick="tryItOut('DELETEapi-users--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-users--id-"
                    onclick="cancelTryOut('DELETEapi-users--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-users--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/users/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-users--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-users--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-users--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the user. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-POSTapi-users-races-register">POST api/users/races/register</h2>

<p>
</p>



<span id="example-requests-POSTapi-users-races-register">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/users/races/register" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"USE_ID\": 16,
    \"RAC_ID\": 16,
    \"USR_CHIP_NUMBER\": \"n\",
    \"USR_TIME\": 16
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/users/races/register"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "USE_ID": 16,
    "RAC_ID": 16,
    "USR_CHIP_NUMBER": "n",
    "USR_TIME": 16
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-users-races-register">
</span>
<span id="execution-results-POSTapi-users-races-register" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-users-races-register"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-users-races-register"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-users-races-register" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-users-races-register">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-users-races-register" data-method="POST"
      data-path="api/users/races/register"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-users-races-register', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-users-races-register"
                    onclick="tryItOut('POSTapi-users-races-register');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-users-races-register"
                    onclick="cancelTryOut('POSTapi-users-races-register');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-users-races-register"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/users/races/register</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-users-races-register"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-users-races-register"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USE_ID</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="USE_ID"                data-endpoint="POSTapi-users-races-register"
               value="16"
               data-component="body">
    <br>
<p>The <code>USE_ID</code> of an existing record in the SAN_USERS table. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>RAC_ID</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="RAC_ID"                data-endpoint="POSTapi-users-races-register"
               value="16"
               data-component="body">
    <br>
<p>The <code>RAC_ID</code> of an existing record in the SAN_RACES table. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USR_CHIP_NUMBER</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="USR_CHIP_NUMBER"                data-endpoint="POSTapi-users-races-register"
               value="n"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USR_TIME</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="USR_TIME"                data-endpoint="POSTapi-users-races-register"
               value="16"
               data-component="body">
    <br>
<p>Example: <code>16</code></p>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-teams">POST api/teams</h2>

<p>
</p>



<span id="example-requests-POSTapi-teams">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/teams" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/teams"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-teams">
</span>
<span id="execution-results-POSTapi-teams" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-teams"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-teams"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-teams" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-teams">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-teams" data-method="POST"
      data-path="api/teams"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-teams', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-teams"
                    onclick="tryItOut('POSTapi-teams');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-teams"
                    onclick="cancelTryOut('POSTapi-teams');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-teams"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/teams</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-teams"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-teams"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTapi-teams-addMember">POST api/teams/addMember</h2>

<p>
</p>



<span id="example-requests-POSTapi-teams-addMember">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/teams/addMember" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"user_id\": 16,
    \"team_id\": 16,
    \"race_id\": 16
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/teams/addMember"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "user_id": 16,
    "team_id": 16,
    "race_id": 16
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-teams-addMember">
</span>
<span id="execution-results-POSTapi-teams-addMember" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-teams-addMember"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-teams-addMember"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-teams-addMember" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-teams-addMember">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-teams-addMember" data-method="POST"
      data-path="api/teams/addMember"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-teams-addMember', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-teams-addMember"
                    onclick="tryItOut('POSTapi-teams-addMember');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-teams-addMember"
                    onclick="cancelTryOut('POSTapi-teams-addMember');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-teams-addMember"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/teams/addMember</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-teams-addMember"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-teams-addMember"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>user_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="user_id"                data-endpoint="POSTapi-teams-addMember"
               value="16"
               data-component="body">
    <br>
<p>The <code>USE_ID</code> of an existing record in the SAN_USERS table. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>team_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="team_id"                data-endpoint="POSTapi-teams-addMember"
               value="16"
               data-component="body">
    <br>
<p>The <code>TEA_ID</code> of an existing record in the SAN_TEAMS table. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>race_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="race_id"                data-endpoint="POSTapi-teams-addMember"
               value="16"
               data-component="body">
    <br>
<p>The <code>RAC_ID</code> of an existing record in the SAN_RACES table. Example: <code>16</code></p>
        </div>
        </form>

                    <h2 id="endpoints-GETapi-races--raceId--available-users">Get users for a specific race with availability status
Returns all matching gender users, flagging those unavailable</h2>

<p>
</p>



<span id="example-requests-GETapi-races--raceId--available-users">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/races/1/available-users" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/races/1/available-users"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-races--raceId--available-users">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-races--raceId--available-users" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-races--raceId--available-users"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-races--raceId--available-users"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-races--raceId--available-users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-races--raceId--available-users">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-races--raceId--available-users" data-method="GET"
      data-path="api/races/{raceId}/available-users"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-races--raceId--available-users', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-races--raceId--available-users"
                    onclick="tryItOut('GETapi-races--raceId--available-users');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-races--raceId--available-users"
                    onclick="cancelTryOut('GETapi-races--raceId--available-users');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-races--raceId--available-users"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/races/{raceId}/available-users</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-races--raceId--available-users"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-races--raceId--available-users"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>raceId</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="raceId"                data-endpoint="GETapi-races--raceId--available-users"
               value="1"
               data-component="url">
    <br>
<p>Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-POSTapi-teams--teamId--register-race">Register a team to a race</h2>

<p>
</p>



<span id="example-requests-POSTapi-teams--teamId--register-race">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/teams/1/register-race" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"race_id\": 16
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/teams/1/register-race"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "race_id": 16
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-teams--teamId--register-race">
</span>
<span id="execution-results-POSTapi-teams--teamId--register-race" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-teams--teamId--register-race"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-teams--teamId--register-race"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-teams--teamId--register-race" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-teams--teamId--register-race">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-teams--teamId--register-race" data-method="POST"
      data-path="api/teams/{teamId}/register-race"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-teams--teamId--register-race', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-teams--teamId--register-race"
                    onclick="tryItOut('POSTapi-teams--teamId--register-race');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-teams--teamId--register-race"
                    onclick="cancelTryOut('POSTapi-teams--teamId--register-race');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-teams--teamId--register-race"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/teams/{teamId}/register-race</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-teams--teamId--register-race"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-teams--teamId--register-race"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>teamId</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="teamId"                data-endpoint="POSTapi-teams--teamId--register-race"
               value="1"
               data-component="url">
    <br>
<p>Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>race_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="race_id"                data-endpoint="POSTapi-teams--teamId--register-race"
               value="16"
               data-component="body">
    <br>
<p>The <code>RAC_ID</code> of an existing record in the SAN_RACES table. Example: <code>16</code></p>
        </div>
        </form>

                    <h2 id="endpoints-GETapi-teams--teamId--races--raceId-">Get team details for a specific race (including members&#039; race info)</h2>

<p>
</p>



<span id="example-requests-GETapi-teams--teamId--races--raceId-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/teams/1/races/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/teams/1/races/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-teams--teamId--races--raceId-">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-teams--teamId--races--raceId-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-teams--teamId--races--raceId-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-teams--teamId--races--raceId-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-teams--teamId--races--raceId-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-teams--teamId--races--raceId-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-teams--teamId--races--raceId-" data-method="GET"
      data-path="api/teams/{teamId}/races/{raceId}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-teams--teamId--races--raceId-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-teams--teamId--races--raceId-"
                    onclick="tryItOut('GETapi-teams--teamId--races--raceId-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-teams--teamId--races--raceId-"
                    onclick="cancelTryOut('GETapi-teams--teamId--races--raceId-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-teams--teamId--races--raceId-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/teams/{teamId}/races/{raceId}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-teams--teamId--races--raceId-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-teams--teamId--races--raceId-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>teamId</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="teamId"                data-endpoint="GETapi-teams--teamId--races--raceId-"
               value="1"
               data-component="url">
    <br>
<p>Example: <code>1</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>raceId</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="raceId"                data-endpoint="GETapi-teams--teamId--races--raceId-"
               value="1"
               data-component="url">
    <br>
<p>Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-POSTapi-teams-member-remove">Remove a member from the team and race</h2>

<p>
</p>



<span id="example-requests-POSTapi-teams-member-remove">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/teams/member/remove" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"team_id\": 16,
    \"user_id\": 16,
    \"race_id\": 16
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/teams/member/remove"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "team_id": 16,
    "user_id": 16,
    "race_id": 16
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-teams-member-remove">
</span>
<span id="execution-results-POSTapi-teams-member-remove" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-teams-member-remove"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-teams-member-remove"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-teams-member-remove" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-teams-member-remove">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-teams-member-remove" data-method="POST"
      data-path="api/teams/member/remove"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-teams-member-remove', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-teams-member-remove"
                    onclick="tryItOut('POSTapi-teams-member-remove');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-teams-member-remove"
                    onclick="cancelTryOut('POSTapi-teams-member-remove');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-teams-member-remove"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/teams/member/remove</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-teams-member-remove"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-teams-member-remove"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>team_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="team_id"                data-endpoint="POSTapi-teams-member-remove"
               value="16"
               data-component="body">
    <br>
<p>Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>user_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="user_id"                data-endpoint="POSTapi-teams-member-remove"
               value="16"
               data-component="body">
    <br>
<p>Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>race_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="race_id"                data-endpoint="POSTapi-teams-member-remove"
               value="16"
               data-component="body">
    <br>
<p>Example: <code>16</code></p>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-teams-member-update-info">Update member&#039;s race info (PPS, Chip)</h2>

<p>
</p>



<span id="example-requests-POSTapi-teams-member-update-info">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/teams/member/update-info" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"team_id\": 16,
    \"race_id\": 16,
    \"user_id\": 16,
    \"chip_number\": \"architecto\",
    \"pps\": \"architecto\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/teams/member/update-info"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "team_id": 16,
    "race_id": 16,
    "user_id": 16,
    "chip_number": "architecto",
    "pps": "architecto"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-teams-member-update-info">
</span>
<span id="execution-results-POSTapi-teams-member-update-info" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-teams-member-update-info"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-teams-member-update-info"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-teams-member-update-info" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-teams-member-update-info">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-teams-member-update-info" data-method="POST"
      data-path="api/teams/member/update-info"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-teams-member-update-info', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-teams-member-update-info"
                    onclick="tryItOut('POSTapi-teams-member-update-info');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-teams-member-update-info"
                    onclick="cancelTryOut('POSTapi-teams-member-update-info');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-teams-member-update-info"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/teams/member/update-info</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-teams-member-update-info"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-teams-member-update-info"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>team_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="team_id"                data-endpoint="POSTapi-teams-member-update-info"
               value="16"
               data-component="body">
    <br>
<p>Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>race_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="race_id"                data-endpoint="POSTapi-teams-member-update-info"
               value="16"
               data-component="body">
    <br>
<p>Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>user_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="user_id"                data-endpoint="POSTapi-teams-member-update-info"
               value="16"
               data-component="body">
    <br>
<p>Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>chip_number</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="chip_number"                data-endpoint="POSTapi-teams-member-update-info"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>pps</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="pps"                data-endpoint="POSTapi-teams-member-update-info"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-teams-validate-race">Validate the team for the race</h2>

<p>
</p>



<span id="example-requests-POSTapi-teams-validate-race">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/teams/validate-race" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"team_id\": 16,
    \"race_id\": 16
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/teams/validate-race"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "team_id": 16,
    "race_id": 16
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-teams-validate-race">
</span>
<span id="execution-results-POSTapi-teams-validate-race" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-teams-validate-race"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-teams-validate-race"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-teams-validate-race" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-teams-validate-race">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-teams-validate-race" data-method="POST"
      data-path="api/teams/validate-race"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-teams-validate-race', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-teams-validate-race"
                    onclick="tryItOut('POSTapi-teams-validate-race');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-teams-validate-race"
                    onclick="cancelTryOut('POSTapi-teams-validate-race');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-teams-validate-race"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/teams/validate-race</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-teams-validate-race"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-teams-validate-race"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>team_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="team_id"                data-endpoint="POSTapi-teams-validate-race"
               value="16"
               data-component="body">
    <br>
<p>Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>race_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="race_id"                data-endpoint="POSTapi-teams-validate-race"
               value="16"
               data-component="body">
    <br>
<p>Example: <code>16</code></p>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-teams-unvalidate-race">Unvalidate the team for the race (if race hasn&#039;t started)</h2>

<p>
</p>



<span id="example-requests-POSTapi-teams-unvalidate-race">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/teams/unvalidate-race" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"team_id\": 16,
    \"race_id\": 16
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/teams/unvalidate-race"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "team_id": 16,
    "race_id": 16
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-teams-unvalidate-race">
</span>
<span id="execution-results-POSTapi-teams-unvalidate-race" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-teams-unvalidate-race"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-teams-unvalidate-race"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-teams-unvalidate-race" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-teams-unvalidate-race">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-teams-unvalidate-race" data-method="POST"
      data-path="api/teams/unvalidate-race"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-teams-unvalidate-race', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-teams-unvalidate-race"
                    onclick="tryItOut('POSTapi-teams-unvalidate-race');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-teams-unvalidate-race"
                    onclick="cancelTryOut('POSTapi-teams-unvalidate-race');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-teams-unvalidate-race"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/teams/unvalidate-race</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-teams-unvalidate-race"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-teams-unvalidate-race"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>team_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="team_id"                data-endpoint="POSTapi-teams-unvalidate-race"
               value="16"
               data-component="body">
    <br>
<p>Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>race_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="race_id"                data-endpoint="POSTapi-teams-unvalidate-race"
               value="16"
               data-component="body">
    <br>
<p>Example: <code>16</code></p>
        </div>
        </form>

                    <h2 id="endpoints-GETapi-teams--id-">GET api/teams/{id}</h2>

<p>
</p>



<span id="example-requests-GETapi-teams--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/teams/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/teams/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-teams--id-">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-teams--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-teams--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-teams--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-teams--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-teams--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-teams--id-" data-method="GET"
      data-path="api/teams/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-teams--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-teams--id-"
                    onclick="tryItOut('GETapi-teams--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-teams--id-"
                    onclick="cancelTryOut('GETapi-teams--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-teams--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/teams/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-teams--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-teams--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-teams--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the team. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-teams--teamId--users">GET api/teams/{teamId}/users</h2>

<p>
</p>



<span id="example-requests-GETapi-teams--teamId--users">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/teams/1/users" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/teams/1/users"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-teams--teamId--users">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-teams--teamId--users" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-teams--teamId--users"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-teams--teamId--users"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-teams--teamId--users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-teams--teamId--users">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-teams--teamId--users" data-method="GET"
      data-path="api/teams/{teamId}/users"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-teams--teamId--users', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-teams--teamId--users"
                    onclick="tryItOut('GETapi-teams--teamId--users');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-teams--teamId--users"
                    onclick="cancelTryOut('GETapi-teams--teamId--users');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-teams--teamId--users"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/teams/{teamId}/users</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-teams--teamId--users"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-teams--teamId--users"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>teamId</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="teamId"                data-endpoint="GETapi-teams--teamId--users"
               value="1"
               data-component="url">
    <br>
<p>Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-addresses--id-">GET api/addresses/{id}</h2>

<p>
</p>



<span id="example-requests-GETapi-addresses--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/addresses/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/addresses/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-addresses--id-">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-addresses--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-addresses--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-addresses--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-addresses--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-addresses--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-addresses--id-" data-method="GET"
      data-path="api/addresses/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-addresses--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-addresses--id-"
                    onclick="tryItOut('GETapi-addresses--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-addresses--id-"
                    onclick="cancelTryOut('GETapi-addresses--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-addresses--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/addresses/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-addresses--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-addresses--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-addresses--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the address. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-POSTapi-addresses">POST api/addresses</h2>

<p>
</p>



<span id="example-requests-POSTapi-addresses">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/addresses" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"ADD_POSTAL_CODE\": 1,
    \"ADD_CITY\": \"n\",
    \"ADD_STREET_NAME\": \"g\",
    \"ADD_STREET_NUMBER\": \"zmiyvdljnikhwayk\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/addresses"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ADD_POSTAL_CODE": 1,
    "ADD_CITY": "n",
    "ADD_STREET_NAME": "g",
    "ADD_STREET_NUMBER": "zmiyvdljnikhwayk"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-addresses">
</span>
<span id="execution-results-POSTapi-addresses" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-addresses"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-addresses"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-addresses" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-addresses">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-addresses" data-method="POST"
      data-path="api/addresses"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-addresses', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-addresses"
                    onclick="tryItOut('POSTapi-addresses');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-addresses"
                    onclick="cancelTryOut('POSTapi-addresses');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-addresses"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/addresses</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-addresses"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-addresses"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ADD_POSTAL_CODE</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="ADD_POSTAL_CODE"                data-endpoint="POSTapi-addresses"
               value="1"
               data-component="body">
    <br>
<p>Must not be greater than 99999. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ADD_CITY</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ADD_CITY"                data-endpoint="POSTapi-addresses"
               value="n"
               data-component="body">
    <br>
<p>Must not be greater than 100 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ADD_STREET_NAME</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ADD_STREET_NAME"                data-endpoint="POSTapi-addresses"
               value="g"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>g</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ADD_STREET_NUMBER</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ADD_STREET_NUMBER"                data-endpoint="POSTapi-addresses"
               value="zmiyvdljnikhwayk"
               data-component="body">
    <br>
<p>Must not be greater than 20 characters. Example: <code>zmiyvdljnikhwayk</code></p>
        </div>
        </form>

                    <h2 id="endpoints-PUTapi-addresses--id-">PUT api/addresses/{id}</h2>

<p>
</p>



<span id="example-requests-PUTapi-addresses--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://localhost/api/addresses/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"ADD_POSTAL_CODE\": 1,
    \"ADD_CITY\": \"n\",
    \"ADD_STREET_NAME\": \"g\",
    \"ADD_STREET_NUMBER\": \"zmiyvdljnikhwayk\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/addresses/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ADD_POSTAL_CODE": 1,
    "ADD_CITY": "n",
    "ADD_STREET_NAME": "g",
    "ADD_STREET_NUMBER": "zmiyvdljnikhwayk"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-addresses--id-">
</span>
<span id="execution-results-PUTapi-addresses--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-addresses--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-addresses--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-addresses--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-addresses--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-addresses--id-" data-method="PUT"
      data-path="api/addresses/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-addresses--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-addresses--id-"
                    onclick="tryItOut('PUTapi-addresses--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-addresses--id-"
                    onclick="cancelTryOut('PUTapi-addresses--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-addresses--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/addresses/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-addresses--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-addresses--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-addresses--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the address. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ADD_POSTAL_CODE</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="ADD_POSTAL_CODE"                data-endpoint="PUTapi-addresses--id-"
               value="1"
               data-component="body">
    <br>
<p>Must not be greater than 99999. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ADD_CITY</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ADD_CITY"                data-endpoint="PUTapi-addresses--id-"
               value="n"
               data-component="body">
    <br>
<p>Must not be greater than 100 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ADD_STREET_NAME</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ADD_STREET_NAME"                data-endpoint="PUTapi-addresses--id-"
               value="g"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>g</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ADD_STREET_NUMBER</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ADD_STREET_NUMBER"                data-endpoint="PUTapi-addresses--id-"
               value="zmiyvdljnikhwayk"
               data-component="body">
    <br>
<p>Must not be greater than 20 characters. Example: <code>zmiyvdljnikhwayk</code></p>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-clubs--id--members-add">POST api/clubs/{id}/members/add</h2>

<p>
</p>



<span id="example-requests-POSTapi-clubs--id--members-add">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/clubs/1/members/add" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"userId\": 16
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/clubs/1/members/add"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "userId": 16
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-clubs--id--members-add">
</span>
<span id="execution-results-POSTapi-clubs--id--members-add" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-clubs--id--members-add"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-clubs--id--members-add"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-clubs--id--members-add" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-clubs--id--members-add">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-clubs--id--members-add" data-method="POST"
      data-path="api/clubs/{id}/members/add"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-clubs--id--members-add', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-clubs--id--members-add"
                    onclick="tryItOut('POSTapi-clubs--id--members-add');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-clubs--id--members-add"
                    onclick="cancelTryOut('POSTapi-clubs--id--members-add');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-clubs--id--members-add"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/clubs/{id}/members/add</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-clubs--id--members-add"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-clubs--id--members-add"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="POSTapi-clubs--id--members-add"
               value="1"
               data-component="url">
    <br>
<p>The ID of the club. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>userId</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="userId"                data-endpoint="POSTapi-clubs--id--members-add"
               value="16"
               data-component="body">
    <br>
<p>The <code>USE_ID</code> of an existing record in the SAN_USERS table. Example: <code>16</code></p>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-clubs--id--members-remove">POST api/clubs/{id}/members/remove</h2>

<p>
</p>



<span id="example-requests-POSTapi-clubs--id--members-remove">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/clubs/1/members/remove" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"userId\": 16
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/clubs/1/members/remove"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "userId": 16
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-clubs--id--members-remove">
</span>
<span id="execution-results-POSTapi-clubs--id--members-remove" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-clubs--id--members-remove"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-clubs--id--members-remove"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-clubs--id--members-remove" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-clubs--id--members-remove">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-clubs--id--members-remove" data-method="POST"
      data-path="api/clubs/{id}/members/remove"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-clubs--id--members-remove', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-clubs--id--members-remove"
                    onclick="tryItOut('POSTapi-clubs--id--members-remove');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-clubs--id--members-remove"
                    onclick="cancelTryOut('POSTapi-clubs--id--members-remove');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-clubs--id--members-remove"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/clubs/{id}/members/remove</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-clubs--id--members-remove"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-clubs--id--members-remove"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="POSTapi-clubs--id--members-remove"
               value="1"
               data-component="url">
    <br>
<p>The ID of the club. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>userId</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="userId"                data-endpoint="POSTapi-clubs--id--members-remove"
               value="16"
               data-component="body">
    <br>
<p>The <code>USE_ID</code> of an existing record in the SAN_USERS table. Example: <code>16</code></p>
        </div>
        </form>

                    <h2 id="endpoints-GETapi-roles">GET api/roles</h2>

<p>
</p>



<span id="example-requests-GETapi-roles">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/roles" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/roles"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-roles">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-roles" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-roles"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-roles"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-roles" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-roles">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-roles" data-method="GET"
      data-path="api/roles"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-roles', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-roles"
                    onclick="tryItOut('GETapi-roles');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-roles"
                    onclick="cancelTryOut('GETapi-roles');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-roles"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/roles</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-roles"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-roles"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-POSTapi-roles">POST api/roles</h2>

<p>
</p>



<span id="example-requests-POSTapi-roles">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/roles" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"ROL_NAME\": \"b\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/roles"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ROL_NAME": "b"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-roles">
</span>
<span id="execution-results-POSTapi-roles" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-roles"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-roles"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-roles" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-roles">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-roles" data-method="POST"
      data-path="api/roles"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-roles', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-roles"
                    onclick="tryItOut('POSTapi-roles');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-roles"
                    onclick="cancelTryOut('POSTapi-roles');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-roles"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/roles</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-roles"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-roles"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ROL_NAME</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ROL_NAME"                data-endpoint="POSTapi-roles"
               value="b"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>b</code></p>
        </div>
        </form>

                    <h2 id="endpoints-GETapi-roles--id-">GET api/roles/{id}</h2>

<p>
</p>



<span id="example-requests-GETapi-roles--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/roles/564" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/roles/564"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-roles--id-">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-roles--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-roles--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-roles--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-roles--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-roles--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-roles--id-" data-method="GET"
      data-path="api/roles/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-roles--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-roles--id-"
                    onclick="tryItOut('GETapi-roles--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-roles--id-"
                    onclick="cancelTryOut('GETapi-roles--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-roles--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/roles/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-roles--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-roles--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="GETapi-roles--id-"
               value="564"
               data-component="url">
    <br>
<p>The ID of the role. Example: <code>564</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-PUTapi-roles--id-">PUT api/roles/{id}</h2>

<p>
</p>



<span id="example-requests-PUTapi-roles--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://localhost/api/roles/564" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"ROL_NAME\": \"b\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/roles/564"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ROL_NAME": "b"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-roles--id-">
</span>
<span id="execution-results-PUTapi-roles--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-roles--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-roles--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-roles--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-roles--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-roles--id-" data-method="PUT"
      data-path="api/roles/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-roles--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-roles--id-"
                    onclick="tryItOut('PUTapi-roles--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-roles--id-"
                    onclick="cancelTryOut('PUTapi-roles--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-roles--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/roles/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-roles--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-roles--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="PUTapi-roles--id-"
               value="564"
               data-component="url">
    <br>
<p>The ID of the role. Example: <code>564</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ROL_NAME</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ROL_NAME"                data-endpoint="PUTapi-roles--id-"
               value="b"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>b</code></p>
        </div>
        </form>

                    <h2 id="endpoints-DELETEapi-roles--id-">DELETE api/roles/{id}</h2>

<p>
</p>



<span id="example-requests-DELETEapi-roles--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost/api/roles/564" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/roles/564"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-roles--id-">
</span>
<span id="execution-results-DELETEapi-roles--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-roles--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-roles--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-roles--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-roles--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-roles--id-" data-method="DELETE"
      data-path="api/roles/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-roles--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-roles--id-"
                    onclick="tryItOut('DELETEapi-roles--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-roles--id-"
                    onclick="cancelTryOut('DELETEapi-roles--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-roles--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/roles/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-roles--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-roles--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="id"                data-endpoint="DELETEapi-roles--id-"
               value="564"
               data-component="url">
    <br>
<p>The ID of the role. Example: <code>564</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-POSTapi-clubs">POST api/clubs</h2>

<p>
</p>



<span id="example-requests-POSTapi-clubs">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/clubs" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"USE_ID\": 16,
    \"ADD_ID\": 16,
    \"CLU_NAME\": \"n\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/clubs"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "USE_ID": 16,
    "ADD_ID": 16,
    "CLU_NAME": "n"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-clubs">
</span>
<span id="execution-results-POSTapi-clubs" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-clubs"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-clubs"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-clubs" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-clubs">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-clubs" data-method="POST"
      data-path="api/clubs"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-clubs', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-clubs"
                    onclick="tryItOut('POSTapi-clubs');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-clubs"
                    onclick="cancelTryOut('POSTapi-clubs');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-clubs"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/clubs</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-clubs"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-clubs"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USE_ID</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="USE_ID"                data-endpoint="POSTapi-clubs"
               value="16"
               data-component="body">
    <br>
<p>The <code>USE_ID</code> of an existing record in the SAN_USERS table. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ADD_ID</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="ADD_ID"                data-endpoint="POSTapi-clubs"
               value="16"
               data-component="body">
    <br>
<p>The <code>ADD_ID</code> of an existing record in the SAN_ADDRESSES table. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>CLU_NAME</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="CLU_NAME"                data-endpoint="POSTapi-clubs"
               value="n"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>n</code></p>
        </div>
        </form>

                    <h2 id="endpoints-POSTapi-clubs-with-address">POST api/clubs/with-address</h2>

<p>
</p>



<span id="example-requests-POSTapi-clubs-with-address">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/clubs/with-address" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"USE_ID\": 16,
    \"CLU_NAME\": \"n\",
    \"ADD_POSTAL_CODE\": \"69775\",
    \"ADD_CITY\": \"n\",
    \"ADD_STREET_NAME\": \"g\",
    \"ADD_STREET_NUMBER\": \"zmiyvdlj\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/clubs/with-address"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "USE_ID": 16,
    "CLU_NAME": "n",
    "ADD_POSTAL_CODE": "69775",
    "ADD_CITY": "n",
    "ADD_STREET_NAME": "g",
    "ADD_STREET_NUMBER": "zmiyvdlj"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-clubs-with-address">
</span>
<span id="execution-results-POSTapi-clubs-with-address" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-clubs-with-address"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-clubs-with-address"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-clubs-with-address" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-clubs-with-address">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-clubs-with-address" data-method="POST"
      data-path="api/clubs/with-address"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-clubs-with-address', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-clubs-with-address"
                    onclick="tryItOut('POSTapi-clubs-with-address');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-clubs-with-address"
                    onclick="cancelTryOut('POSTapi-clubs-with-address');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-clubs-with-address"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/clubs/with-address</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-clubs-with-address"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-clubs-with-address"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USE_ID</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="USE_ID"                data-endpoint="POSTapi-clubs-with-address"
               value="16"
               data-component="body">
    <br>
<p>The <code>USE_ID</code> of an existing record in the SAN_USERS table. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>CLU_NAME</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="CLU_NAME"                data-endpoint="POSTapi-clubs-with-address"
               value="n"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ADD_POSTAL_CODE</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ADD_POSTAL_CODE"                data-endpoint="POSTapi-clubs-with-address"
               value="69775"
               data-component="body">
    <br>
<p>Must be 5 digits. Example: <code>69775</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ADD_CITY</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ADD_CITY"                data-endpoint="POSTapi-clubs-with-address"
               value="n"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ADD_STREET_NAME</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ADD_STREET_NAME"                data-endpoint="POSTapi-clubs-with-address"
               value="g"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>g</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ADD_STREET_NUMBER</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ADD_STREET_NUMBER"                data-endpoint="POSTapi-clubs-with-address"
               value="zmiyvdlj"
               data-component="body">
    <br>
<p>Must not be greater than 8 characters. Example: <code>zmiyvdlj</code></p>
        </div>
        </form>

                    <h2 id="endpoints-PUTapi-clubs--id-">PUT api/clubs/{id}</h2>

<p>
</p>



<span id="example-requests-PUTapi-clubs--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://localhost/api/clubs/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"CLU_NAME\": \"b\",
    \"USE_ID\": 16,
    \"ADD_POSTAL_CODE\": \"69775\",
    \"ADD_CITY\": \"n\",
    \"ADD_STREET_NAME\": \"g\",
    \"ADD_STREET_NUMBER\": \"zmiyvdlj\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/clubs/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "CLU_NAME": "b",
    "USE_ID": 16,
    "ADD_POSTAL_CODE": "69775",
    "ADD_CITY": "n",
    "ADD_STREET_NAME": "g",
    "ADD_STREET_NUMBER": "zmiyvdlj"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-clubs--id-">
</span>
<span id="execution-results-PUTapi-clubs--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-clubs--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-clubs--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-clubs--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-clubs--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-clubs--id-" data-method="PUT"
      data-path="api/clubs/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-clubs--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-clubs--id-"
                    onclick="tryItOut('PUTapi-clubs--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-clubs--id-"
                    onclick="cancelTryOut('PUTapi-clubs--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-clubs--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/clubs/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-clubs--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-clubs--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-clubs--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the club. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>CLU_NAME</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="CLU_NAME"                data-endpoint="PUTapi-clubs--id-"
               value="b"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>b</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USE_ID</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="USE_ID"                data-endpoint="PUTapi-clubs--id-"
               value="16"
               data-component="body">
    <br>
<p>The <code>USE_ID</code> of an existing record in the SAN_USERS table. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ADD_POSTAL_CODE</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ADD_POSTAL_CODE"                data-endpoint="PUTapi-clubs--id-"
               value="69775"
               data-component="body">
    <br>
<p>Must be 5 digits. Example: <code>69775</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ADD_CITY</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ADD_CITY"                data-endpoint="PUTapi-clubs--id-"
               value="n"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ADD_STREET_NAME</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ADD_STREET_NAME"                data-endpoint="PUTapi-clubs--id-"
               value="g"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>g</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ADD_STREET_NUMBER</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ADD_STREET_NUMBER"                data-endpoint="PUTapi-clubs--id-"
               value="zmiyvdlj"
               data-component="body">
    <br>
<p>Must not be greater than 8 characters. Example: <code>zmiyvdlj</code></p>
        </div>
        </form>

                    <h2 id="endpoints-DELETEapi-clubs--id-">DELETE api/clubs/{id}</h2>

<p>
</p>



<span id="example-requests-DELETEapi-clubs--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost/api/clubs/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/clubs/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-clubs--id-">
</span>
<span id="execution-results-DELETEapi-clubs--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-clubs--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-clubs--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-clubs--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-clubs--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-clubs--id-" data-method="DELETE"
      data-path="api/clubs/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-clubs--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-clubs--id-"
                    onclick="tryItOut('DELETEapi-clubs--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-clubs--id-"
                    onclick="cancelTryOut('DELETEapi-clubs--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-clubs--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/clubs/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-clubs--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-clubs--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-clubs--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the club. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-GETapi-addresses">GET api/addresses</h2>

<p>
</p>



<span id="example-requests-GETapi-addresses">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/addresses" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/addresses"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-addresses">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-addresses" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-addresses"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-addresses"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-addresses" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-addresses">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-addresses" data-method="GET"
      data-path="api/addresses"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-addresses', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-addresses"
                    onclick="tryItOut('GETapi-addresses');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-addresses"
                    onclick="cancelTryOut('GETapi-addresses');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-addresses"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/addresses</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-addresses"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-addresses"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="endpoints-DELETEapi-addresses--id-">DELETE api/addresses/{id}</h2>

<p>
</p>



<span id="example-requests-DELETEapi-addresses--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://localhost/api/addresses/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/addresses/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-addresses--id-">
</span>
<span id="execution-results-DELETEapi-addresses--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-addresses--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-addresses--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-addresses--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-addresses--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-addresses--id-" data-method="DELETE"
      data-path="api/addresses/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-addresses--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-addresses--id-"
                    onclick="tryItOut('DELETEapi-addresses--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-addresses--id-"
                    onclick="cancelTryOut('DELETEapi-addresses--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-addresses--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/addresses/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-addresses--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-addresses--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-addresses--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the address. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="endpoints-POSTapi-users--id-">POST api/users/{id}</h2>

<p>
</p>



<span id="example-requests-POSTapi-users--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost/api/users/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"USE_MAIL\": \"gbailey@example.net\",
    \"USE_PASSWORD\": \"miyvdljnikhwaykcmyuwpwlvqw\",
    \"USE_NAME\": \"r\",
    \"USE_LAST_NAME\": \"s\",
    \"USE_GENDER\": \"Autre\",
    \"USE_BIRTHDATE\": \"2026-01-15T15:54:27\",
    \"USE_PHONE_NUMBER\": 16,
    \"USE_LICENCE_NUMBER\": 16,
    \"USE_MEMBERSHIP_DATE\": \"2026-01-15T15:54:27\",
    \"USE_VALIDITY\": \"2026-01-15T15:54:27\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/users/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "USE_MAIL": "gbailey@example.net",
    "USE_PASSWORD": "miyvdljnikhwaykcmyuwpwlvqw",
    "USE_NAME": "r",
    "USE_LAST_NAME": "s",
    "USE_GENDER": "Autre",
    "USE_BIRTHDATE": "2026-01-15T15:54:27",
    "USE_PHONE_NUMBER": 16,
    "USE_LICENCE_NUMBER": 16,
    "USE_MEMBERSHIP_DATE": "2026-01-15T15:54:27",
    "USE_VALIDITY": "2026-01-15T15:54:27"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-users--id-">
</span>
<span id="execution-results-POSTapi-users--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-users--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-users--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-users--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-users--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-users--id-" data-method="POST"
      data-path="api/users/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-users--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-users--id-"
                    onclick="tryItOut('POSTapi-users--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-users--id-"
                    onclick="cancelTryOut('POSTapi-users--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-users--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/users/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-users--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-users--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="POSTapi-users--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the user. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USE_MAIL</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="USE_MAIL"                data-endpoint="POSTapi-users--id-"
               value="gbailey@example.net"
               data-component="body">
    <br>
<p>Must be a valid email address. Example: <code>gbailey@example.net</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USE_PASSWORD</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="USE_PASSWORD"                data-endpoint="POSTapi-users--id-"
               value="miyvdljnikhwaykcmyuwpwlvqw"
               data-component="body">
    <br>
<p>Must be at least 8 characters. Example: <code>miyvdljnikhwaykcmyuwpwlvqw</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USE_NAME</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="USE_NAME"                data-endpoint="POSTapi-users--id-"
               value="r"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>r</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USE_LAST_NAME</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="USE_LAST_NAME"                data-endpoint="POSTapi-users--id-"
               value="s"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>s</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USE_GENDER</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="USE_GENDER"                data-endpoint="POSTapi-users--id-"
               value="Autre"
               data-component="body">
    <br>
<p>Example: <code>Autre</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>Homme</code></li> <li><code>Femme</code></li> <li><code>Autre</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USE_BIRTHDATE</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="USE_BIRTHDATE"                data-endpoint="POSTapi-users--id-"
               value="2026-01-15T15:54:27"
               data-component="body">
    <br>
<p>Must be a valid date. Example: <code>2026-01-15T15:54:27</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USE_PHONE_NUMBER</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="USE_PHONE_NUMBER"                data-endpoint="POSTapi-users--id-"
               value="16"
               data-component="body">
    <br>
<p>Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USE_LICENCE_NUMBER</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="USE_LICENCE_NUMBER"                data-endpoint="POSTapi-users--id-"
               value="16"
               data-component="body">
    <br>
<p>Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USE_MEMBERSHIP_DATE</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="USE_MEMBERSHIP_DATE"                data-endpoint="POSTapi-users--id-"
               value="2026-01-15T15:54:27"
               data-component="body">
    <br>
<p>Must be a valid date. Example: <code>2026-01-15T15:54:27</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>USE_VALIDITY</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="USE_VALIDITY"                data-endpoint="POSTapi-users--id-"
               value="2026-01-15T15:54:27"
               data-component="body">
    <br>
<p>Must be a valid date. Example: <code>2026-01-15T15:54:27</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>CLU_ID</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="CLU_ID"                data-endpoint="POSTapi-users--id-"
               value=""
               data-component="body">
    <br>
<p>The <code>CLU_ID</code> of an existing record in the SAN_CLUBS table.</p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>ADD_ID</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="ADD_ID"                data-endpoint="POSTapi-users--id-"
               value=""
               data-component="body">
    <br>
<p>The <code>ADD_ID</code> of an existing record in the SAN_ADDRESSES table.</p>
        </div>
        </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
