<div id="main">
    <h1>Les pathologies</h1>
    <div class="moteur">
        <h2>Vous recherchez </h2>
        <form id="formPatho" method="GET" action="liste-pathologies" >
            <select multiple name="meridien" id="meridien">
                {foreach from=$argument.Meridiens item=objet}
                    <option value="{$objet->code}">{$objet->nom}</option>
                {/foreach}
            </select> 
            <select multiple name="type" id="type">
                <option value="m">Méridien</option>
                <option value="l2">voie grand luo</option>
                <option value="mv">Chong Mai</option>
                <option value="l">Voie luo</option>
                <option value="j">Jing jin</option>
                <option value="tf">Fu/Zang</option>
            </select> 
            <select multiple name="caracteristique" id="caracteristique">
                <option value="p">plein</option>
                <option value="c">chaud</option>
                <option value="v">vide</option>
                <option value="f">froid</option>
                <option value="i">interne</option>
                <option value="e">externe</option>
            </select> 
            <select multiple name="keyword" id="keyword">
                {foreach from=$argument.Keywords item=objet}
                    <option value="{$objet.idK}">{$objet.name}</option>
                {/foreach}
            </select> 
        </form>
    </div>
    <h2 class="listeh2">Liste des pathologies</h2>
    <div id="resultat">
    {include file="pathologieTableau.tpl" argument=$argument.liste}
    </div>
</div>
