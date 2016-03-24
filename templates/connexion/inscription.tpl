<form method="GET" action="users" id="formConnexion">
    <input name="_method" type="hidden" value="POST" />
    <ul>
        <li>
            <label for="login"> Pseudonyme :</label>
            <input id="login" name="login" type="text"  />
        </li>
        <li>
            <label for="email"> email :</label>
            <input id="email" name="email" type="email"  />
        </li>
        <li>
            <label for="pass"> Mot de passe :</label>
            <input id="pass" name="pass" type="password" />
        </li>
        <li>
            <button id="submit">Envoyer</button> 
        </li>
    </ul>
</form>
