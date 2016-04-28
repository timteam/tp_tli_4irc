<table id="tableauPatho">
    <thead>
        <tr>
            <th>Méridien</th>
            <th>Pathologies</th>
            <th>Symptômes</th>
        </tr>
    </thead>   
    <tbody>  
        {foreach from=$argument key=meridien item=objet}
            {foreach from=$objet key=nom item=patho}
                  <tr>
                    <td>
                        {$meridien}
                    </td>
                    <td>
                        {$nom}
                    </td>
                    <td>
                        {foreach from=$patho item=symptome}
                            {$symptome->desc}
                            {if !$symptome@last}
                              ,
                            {/if}
                        {/foreach}
                    </td>
                </tr>
            {/foreach}
        {/foreach}
    </tbody>
</table>