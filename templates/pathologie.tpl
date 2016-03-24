<div id="main">
    <h1>Liste des pathologies</h1>
    <table>
        <thead>
            <tr>
                <th>Méridien</th>
                <th>Pathologies</th>
            </tr>
        </thead>   
        <tfoot>  
            {foreach from=$argument->Pathologies item=objet}
            <tr>
                <td>
                    {$objet->nom}
                    {$nom = $objet->nom}
                </td>
                <td>
                    {foreach from=$objet->desc item=pathologie name=loop}
                        {if !$smarty.foreach.loop.first}
                            <span class="separateur">, </span>
                        {/if} 
                            {$pathologie|capitalize:false}
                    {/foreach}
                </td>
            </tr>
            {/foreach}
        </tfoot>
    </table>
</div>
