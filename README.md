<html lang="en">
<p>c'est un copier-coller du code de templates/home/index.html.twig. </p>
  <p>images pas là, bootstrap pas pris en compte. Donc pas terrible </p>
  <p>dans tous les cas c'est loin d'être fini</p>

<body>


<h1>Documentation of Symfony Messenger API</h1>
<p>INFO: You need a token/to be logged in to access all the routes starting with /api which means all except the route to register</p>



<h2 id="#user">User and Token</h2>
<div class="card p-2 my-2">
    <div class="d-flex align-items-center mb-2">
        <div class="btn btn-primary me-4">POST</div>
        <p class="me-4 fw-bold">/register</p>
        <p class="text-secondary">Sign up</p>
    </div>
    <ul>
        <li>You need to pass username, email and password to body.
            <img src="{{ asset('images/documentation/register.png') }}" alt="">
        </li>

        <li>User is based on a username. Password is encrypted.</li>
        <li>Two people can't have the same username.</li>
    </ul>
</div>
<div class="card p-2 my-2">
    <div class="d-flex align-items-center mb-2">
        <div class="btn btn-primary me-4">POST</div>
        <p class="me-4 fw-bold">/api/login_check</p>
        <p class="text-secondary">Sign in and get a token</p>
    </div>
    <ul>
        <li>You need to pass username and password to body.
            <img src="{{ asset('images/documentation/gettoken.png') }}" alt=""></li>

        <li>Based on JWT authentification. The token is valid for X (?) and can be refreshed when expired.</li>
        <li>Response :
            <img src="{{ asset('images/documentation/token.png') }}" alt="">
        </li>
    </ul>
</div>
<div class="card p-2 my-2">
    <div class="d-flex align-items-center mb-2">
        <div class="btn btn-primary me-4">POST</div>
        <p class="me-4 fw-bold">/api/token/refresh</p>
        <p class="text-secondary">Refresh your token</p>
    </div>
    <ul>
        <li>You need to pass the refresh_token to get a new token</li>
        <ul>
            <li><img src="{{ asset('images/documentation/refresh.png') }}" alt=""></li>
        </ul>
        <li>Response:
            <ul>
                <li><img src="{{ asset('images/documentation/token.png') }}" alt=""></li>
            </ul>
        </li>
    </ul>
</div>


<div class="card p-2 my-2">
    <div class="d-flex align-items-center mb-2">
        <div class="btn btn-primary me-4">POST</div>
        <p class="me-4 fw-bold">/api/profile/{profileId}/visibility</p>
        <p class="text-secondary">Change your profiles visibility</p>
    </div>
    <ul>
        <li>You need to pass the id of a profile to route.</li>
        <li>Response (boolean):
            <ul>
                <li>"Visibility changed to public/private"</li>
            </ul>
        </li>
    </ul>
</div>
<div class="card p-2 my-2">
    <div class="d-flex align-items-center mb-2">
        <div class="btn btn-success me-4">GET</div>
        <p class="me-4 fw-bold">/api/{profileId}/friends</p>
        <p class="text-secondary">See the friends of a person</p>
    </div>
    <ul>
        <li>You need to pass the id of a profile to route.</li>
    </ul>
</div>
<div class="card p-2 my-2 bg-danger-subtle">
    <div class="d-flex align-items-center mb-2">
        <div class="btn btn-success me-4">GET</div>
        <p class="me-4 fw-bold">/api/conversations/{profileId}</p>
        <p class="text-secondary">See all your private conversations</p>
    </div>
    <ul>
        <li>You need to pass the id of your profile to route.</li>
    </ul>
</div>


<h2 id="#friend">Friend request</h2>
<div class="card p-2 my-2 bg-danger-subtle">
    <div class="d-flex align-items-center mb-2">
        <div class="btn btn-success me-4">GET</div>
        <p class="me-4 fw-bold">/api/friend/request/received/{profileId}</p>
        <p class="text-secondary">Index all the friend requests you received </p>
    </div>
    <ul>
        <li>You need to pass the id of a profile to route.</li>
        <li>Response:
            <ul>
                <li>"None of your business" -> you are trying to see someone else's received requests. Put your id</li>
                <li> else
                    <img src="{{ asset('images/documentation/received-requests.png') }}" alt="">
                </li>
            </ul>
        </li>
    </ul>
</div>
<div class="card p-2 my-2 bg-danger-subtle">
    <div class="d-flex align-items-center mb-2">
        <div class="btn btn-success me-4">GET</div>
        <p class="me-4 fw-bold">/api/friend/request/send/{profileId}</p>
        <p class="text-secondary">Send a friend request </p>
    </div>
    <ul>
        <li>You need to pass the id of the profile (person you want to send it to) to route.</li>
        <li>Response:
            <ul>
                <li>"You are sending yourself a friend request" -> self explanatory. Change the id</li>
                <li>"Already friends" -> self explanatory. Change the id</li>
                <li>"Request already sent" -> self explanatory. Change the id</li>
                <li>"Other party already sent to a friend request" -> self explanatory. Change the id</li>
                <li>"Friend request sent to [username]"</li>
            </ul>
        </li>
    </ul>
</div>
<div class="card p-2 my-2 bg-danger-subtle">
    <div class="d-flex align-items-center mb-2">
        <div class="btn btn-primary me-4">POST</div>
        <p class="me-4 fw-bold">/api/friend/accept/{requestId}</p>
        <p class="text-secondary">Accept a friend request</p>
    </div>
    <ul>
        <li>You need to pass the id of the request you want to accept to route.</li>
        <li>When you accept, Friendship and Private Conversation between you two is created .............</li>
        <li>Response:
            <ul>
                <li>"Not yours to accept" -> The request was not sent to you. Change the id</li>
                <li>"[username]'s friend request accepted"</li>
            </ul>
        </li>
    </ul>
</div>
<div class="card p-2 my-2 bg-danger-subtle">
    <div class="d-flex align-items-center mb-2">
        <div class="btn btn-primary me-4">POST</div>
        <p class="me-4 fw-bold">/api/friend/decline/{requestId}</p>
        <p class="text-secondary">Decline a friend request</p>
    </div>
    <ul>
        <li>You need to pass the id of the request you want to decline to route.</li>
        <li>When you decline, the request is deleted.</li>
        <li>Response:
            <ul>
                <li>"Mind your own business" -> The request was not sent to you. Change the id</li>
                <li>"[username]'s friend request declined"</li>
            </ul>
        </li>
    </ul>
</div>
<div class="card p-2 my-2">
    <div class="d-flex align-items-center mb-2">
        <div class="btn btn-primary me-4">POST</div>
        <p class="me-4 fw-bold">/api/friend/retract/{requestId}</p>
        <p class="text-secondary">Take back a sent friend request</p>
    </div>
    <ul>
        <li>You need to pass the id of the request you want to decline to route.</li>
        <li>When you decline, the request is deleted.</li>
        <li>Response:
            <ul>
                <li>"Mind your own business" -> The request was not sent by you. Change the id</li>
                <li>"It seems something made you change your mind"</li>
            </ul>
        </li>
    </ul>
</div>


<h2 id="#private">Private Conversation</h2>
<div class="card p-2 my-2 bg-secondary-subtle">
    <div class="d-flex align-items-center mb-2">
        <div class="btn btn-success me-4">GET</div>
        <p class="me-4 fw-bold">/api/conversation/{id}</p>
        <p class="text-secondary">Index a private conversation</p>
    </div>
    <ul>
        <li>You need to pass the id of the private conversation to route.</li>
        <li>Response:
            <ul>
                <li>"Mind your own business" -> Not one of your private conversations. Change the id</li>
                <li>Response:
                    <img src="{{ asset('') }}" alt="">
                </li>
            </ul>
        </li>
    </ul>
</div>
<div class="card p-2 my-2 ">
    <div class="d-flex align-items-center mb-2 ">
        <div class="btn btn-primary me-4">POST</div>
        <p class="me-4 fw-bold">/api/private/conversation/{id}/message/new</p>
        <p class="text-secondary">Write message in a private conversation of yours</p>
    </div>
    <ul>
        <li>You need to pass the id of the private conversation to route.</li>
        <li>You can write text and send previously uploaded images.</li>
        <li>You need to add a content to the body. Associated images is an array of ids of previously uploaded images which can be empty.</li>
        <ul>
            <li><img src="{{ asset('images/documentation/newmsg.png') }}" alt=""></li>
            <li><img src="{{ asset('images/documentation/newmsg2.png') }}" alt=""></li>
        </ul>
        <li>Response:
            <ul>
                <li>"Not one of your private conversations" -> You are not part of the conversation. Change the id</li>
                <li>"Message sent"</li>
            </ul>
        </li>
    </ul>
</div>
<div class="card p-2 my-2 ">
    <div class="d-flex align-items-center mb-2 ">
        <div class="btn btn-danger me-4">DELETE</div>
        <p class="me-4 fw-bold">/api/private/conversation/{id}/delete/{messageId}</p>
        <p class="text-secondary">Delete a message in a private conversation of yours</p>
    </div>
    <ul>
        <li>You need to pass the id of the private conversation and the id of the message to route.</li>
        <li>Response:
            <ul>
                <li>"Not yours to delete" -> You are not the author of the message. Change the message id</li>
                <li>"Message deleted"</li>
            </ul>
        </li>
    </ul>
</div>
<div class="card p-2 my-2 ">
    <div class="d-flex align-items-center mb-2 ">
        <div class="btn btn-warning me-4">PUT</div>
        <p class="me-4 fw-bold">/api/private/conversation/{id}/edit/{messageId}</p>
        <p class="text-secondary">Edit a message in a private conversation of yours</p>
    </div>
    <ul>
        <li>You need to pass the id of the private conversation and the id of the message to route.</li>
        <li>You need to add a content to the body. Images can't be edited.</li>
        <ul>
            <li><img src="{{ asset('') }}" alt=""></li>
        </ul>
        <li>Response:
            <ul>
                <li>"Not yours to change" -> You are not the author of the message. Change the message id</li>
                <li>"Message edited"</li>
            </ul>
        </li>
    </ul>
</div>



<h2 id="#group">Group Conversation</h2>
<div class="card p-2 my-2 bg-secondary-subtle">
    <div class="d-flex align-items-center mb-2 ">
        <div class="btn btn-primary me-4">GET</div>
        <p class="me-4 fw-bold">/api/group/conversation/{id}</p>
        <p class="text-secondary">Index all messages of a group conversation.</p>
    </div>
    <ul>
        <li>You need to pass the id of the private conversation to route.</li>
        <li>Response:
            <ul>
                <li>"You are not part of the group" -> ..... Change the id</li>
                <li>
                    <img src="" alt="">
                </li>
            </ul>
        </li>
    </ul>
</div>


<h2 id="#community">Community Channel</h2>

<h2 id="#dashboard">Dashboard</h2>
<p class="col-9">This part is purely to visualize if stuff worked. You are not supposed to see all the things that don't concern you. Could be used for KPI stuff ........................</p>
<div class="card p-2 my-2">
    <div class="d-flex align-items-center mb-2">
        <div class="btn btn-success me-4">GET</div>
        <p class="me-4 fw-bold">/api/profiles</p>
        <p class="text-secondary">Index all existing profiles</p>
    </div>
    <ul>
        <li>Response:
            <img src="{{ asset('images/documentation/profiles.png') }}" alt="">
        </li>
    </ul>
</div>
<div class="card p-2 my-2">
    <div class="d-flex align-items-center mb-2">
        <div class="btn btn-success me-4">GET</div>
        <p class="me-4 fw-bold">/api/requests</p>
        <p class="text-secondary">Index all sent friend requests</p>
    </div>
    <ul>
        <li>Response:
            <img src="{{ asset('images/documentation/index-friend-requests.png') }}" alt="">
        </li>
    </ul>
</div>
<div class="card p-2 my-2">
    <div class="d-flex align-items-center mb-2">
        <div class="btn btn-success me-4">GET</div>
        <p class="me-4 fw-bold">/api/private/conversations</p>
        <p class="text-secondary">Index all private conversation pairs</p>
    </div>
    <ul>
        <li>Response:
            <img src="{{ asset('') }}" alt="">
        </li>
    </ul>
</div>




</body>
</html>
