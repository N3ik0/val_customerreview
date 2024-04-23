{if isset($reviews)}
     <div id="product-reviews">
          {foreach from=$reviews item=review name=review}
               {if $smarty.foreach.review.index < 5}
                    <div class="review-solo">
                         <p><strong>{$review.name_customer}</strong>: </p>
                         <p>{$review.comment}</p>
                         <p>Note: {$review.note} <i class="material-icons">star</i></p>
                    </div>
               {/if}
          {/foreach}
     </div>
{/if}

{if !$reviews|@count}
     <div id="empty-comment">
          <p>Soyez le premier à donner votre avis !</p>
     </div>
{/if}

     {if isset($titlereview)}
     <div id="empty-product-comment" class="product-comment-list-item">

          {if $customer.is_logged}
          <a class="btn btn-primary" href="{$formReview}">
          Donnez nous votre avis</a>
          {else}
               <div> Vous devez vous connecter pour commenter ce produit</div>
          {/if}
     </div>
{/if}