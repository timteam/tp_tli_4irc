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
            {foreach from=$argument item=meridien}
            <tr>
                <td>
                    {$meridien.nom}
                </td>
                <td>
                    {foreach from=$meridien.desc item=pathologie name=loop}
                        {if !$smarty.foreach.loop.first}<span class="separateur">, </span>{/if} 
                            {$pathologie|capitalize:false}
                    {/foreach}
                </td>
            </tr>
            {/foreach}
        </tfoot>
    </table>
</div>