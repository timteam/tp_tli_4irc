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
        <tr>
            <td rowspan="{$objet|@count} ">
                {$meridien}
            </td>
            {foreach from=$objet key=nom item=patho}
                {if !$patho@first}
                  <tr>
                {/if}
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