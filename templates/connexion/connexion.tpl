<form method="GET" action="sessions" id="formConnexion">
    <input type="hidden" name="_method" value="POST">
    <ul>
        <li>
            <label for="login"> Pseudonyme </label>
            <input id="login" name="login" aria-describedby="username-tip" type="text" />
            <div role="tooltip" id="username-tip">Mettre votre pseudonyme ici</div>
	
        </li>
        <li>
            <label for="pass"> Mot de passe </label>
            <input id="pass" name="pass" aria-describedby="password-tip" type="password" />
            <div role="tooltip" id="password-tip">Mettre votre mot de passe ici</div>
        </li>
        <li>
            <button id="submit">Envoyer</button> 
        </li>
    </ul>
</form>
