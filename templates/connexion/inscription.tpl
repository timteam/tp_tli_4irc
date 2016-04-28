<form method="GET" action="users" id="formConnexion">
    <input name="_method" type="hidden" value="POST" />
    <ul>
        <li>
            <label for="login"> Pseudonyme </label>
            <input id="login" name="login" type="text" aria-describedby="username-tip"  />
            <div role="tooltip" id="username-tip">Mettre votre pseudonyme ici</div>
        </li>
        <li>
            <label for="email"> Email </label>
            <input id="email" name="email" aria-describedby="email-tip" type="email"  />
            <div role="tooltip" id="email-tip">Mettre votre email ici</div>
        </li>
        <li>
            <label for="pass"> Mot de passe </label>
            <input id="pass" name="pass" type="password" aria-describedby="password-tip" />
            <div role="tooltip" id="password-tip">Mettre votre mot de passe ici</div>
        </li>
        <li>
            <button id="submit">Envoyer</button> 
        </li>
    </ul>
</form>
