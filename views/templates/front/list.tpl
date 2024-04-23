{extends file="page.tpl"}

{block name="page_content"}
    <h1>Vos devis</h1>
    <table class="table">
        <tr>
            <th>Date</th>
            <th>Produit</th>
            <th>Action</th>
        </tr>
        {foreach from=$quotes item=quote}
            <tr>
                <td>{dateFormat date = $quote.date_add full=1}</td>
                <td>{$quote.name}</td>
                <td><a href="{$link->getModuleLink('val_customerreview', 'ListReview',['action' => 'delete', 'id_review' => $quote.id_review])}" class="btn btn-primary">Supprimer</a></td>
                <td><a href="{$link->getModuleLink('val_customerreview', 'FormReview',['id_product' => $quote.id_product, 'id_review' => $quote.id_review])}" class="btn btn-primary">Modifier</a></td>
            </tr>
        {/foreach}
    </table>
{/block}