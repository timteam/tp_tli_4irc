<div id="main">
    <h3>Liste des pathologies</h3>
    <table>
        <thead>
            <tr>
                <th>Méridien</th>
                <th>Pathologies</th>
            </tr>
        </thead>   
        <tfoot>  
            {foreach from=$argument item=objet}
            <tr>
                <td>
                    {$objet->nom}
                </td>
                <td>
                    {foreach from=$objet->desc item=pathologie name=loop}
                        {if !$smarty.foreach.loop.first}<span class="separateur">, </span>{/if} 
                            {$pathologie}
                    {/foreach}
                </td>
            </tr>
            {/foreach}
        </tfoot>
    </table>
</div>