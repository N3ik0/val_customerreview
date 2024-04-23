{extends file="page.tpl"}

{block name="page_content"}

     {if isset($confirmation)}<div class="alert alert-success">Votre commentaire a bien été modifié</div>{/if}
     <div id="globalForm">
          <div id="formReview">
               <h1 class=>Votre commentaire : {$product->name}</h1>
               <form method="post">
                    <label for "message">Review</label>
                    <textarea name="comment" id="comment" required>{if isset($review[0].comment)}{$review[0].comment}{/if}</textarea>
                    <label for "note">Note</label>
                    <select name="note" id="note">
                         <option value="">--Choisissez une note--</option>
                         <option value="1" {if isset($review[0].note) && $review[0].note == 1}selected{/if}>1</option>
                         <option value="2" {if isset($review[0].note) && $review[0].note == 2}selected{/if}>2</option>
                         <option value="3" {if isset($review[0].note) && $review[0].note == 3}selected{/if}>3</option>
                         <option value="4" {if isset($review[0].note) && $review[0].note == 4}selected{/if}>4</option>
                         <option value="5" {if isset($review[0].note) && $review[0].note == 5}selected{/if}>5</option>
                    </select>
                    <input type="submit" value="Envoyer" name="submit_review">
               </form>
          </div>
     </div>
{/block}