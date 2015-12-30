<table class="table table-bordered table-stripes table-hover" style="width: auto;">
    <thead>
    <tr>
        <th>
            ID
        </th>
        <th>
            Name
        </th>
    </tr>
    </thead>
<tbody>
{if $categories}
    {foreach $categories as $c}
        <tr>
            <td>
                {$c.id}
            </td>
            <td>
                {$c.name}
            </td>
        </tr>
    {/foreach}
{/if}
</tbody>
</table>