       <header>
            {if $user == false}
                <div id="join" class="ajax-popup" data-href="sessions" data-titre="Connexion à Acupuntura">
                    Connexion
                </div>
                <div id="login" class="ajax-popup" data-href="users/register" data-titre="Inscription à Acupuntura">
                    Inscription
                </div>
            {else}
                <div id="loginOn">
                    Bonjour {$user}
                </div>
                <div id="logout" class="logout-class" data-href="sessions" data-titre="Déconnexion à Acupuntura">
                    Déconnexion
                </div>
            {/if}
            <div id="titre">
                ACUPUNTURA
            </div>
            <div id="soustitre">
                <span>U</span>ne <span>M</span>édecine <span>M</span>illénaire <span>C</span>hinoise
            </div>
            <div id="navigation">
                <nav>
                    <ul>
                        <li><img alt="Accueil" src="/media/images/pagode.png"><a href="home">Accueil</a></li>
                        <li><a href="pathologies">Les pathologies</a></li>
                        <li><a href="infos">Informations</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <hr />
