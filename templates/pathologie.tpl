<div id="main">
    <h1>Liste des pathologies</h1>
    <table>
        <thead>
            <td>Pathologie</td>
        </thead>   
        <tfoot>  
            {foreach from=$argument item=pathologie}
            <tr>
                <td>
                    {$pathologie.desc}
                </td>
            </tr>
            {/foreach}
        </tfoot>
    </table>
</div>