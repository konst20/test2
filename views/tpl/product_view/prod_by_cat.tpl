<table class="table table-bordered table-stripes table-hover" style="width: auto;">
    <thead>
    <tr>
        <th>
            ID
        </th>
        <th>
            Name
        </th>
        <th>
            Details
        </th>
    </tr>
    </thead>
    <tbody>
    {if $products}
        {foreach $products as $p}
            <tr>
                <td>
                    {$p.id}
                </td>
                <td>
                    {$p.name}
                </td>
                <td>
                    {$p.details}
                </td>
            </tr>
        {/foreach}
    {/if}
    </tbody>
</table>