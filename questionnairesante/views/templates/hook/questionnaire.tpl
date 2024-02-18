<div id="questionnaire-form" class="container mt-4">
    <form action="{$link->getPageLink('questionnairesante', true)}" method="post" class="form">
        <fieldset>
            <legend>{l s='Questionnaire de Santé' mod='questionnairesante'}</legend>
            <div class="mb-2">
                <label for="age" class="form-label">{l s='Age' mod='questionnairesante'}:</label>
                <input type="number" name="age" id="age" class="form-control" required>
            </div>
            <div class="mb-2">
                <label for="allergies" class="form-label">{l s='Allergies' mod='questionnairesante'}:</label>
                <input type="text" name="allergies" id="allergies" class="form-control" required>
            </div>
            <div class="mb-2">
                <label for="poids" class="form-label">{l s='Poids' mod='questionnairesante'}:</label>
                <input type="number" name="poids" id="poids" class="form-control" required>
            </div>
            <div class="mb-2">
                <label for="taille" class="form-label">{l s='Taille' mod='questionnairesante'}:</label>
                <input type="text" name="taille" id="taille" class="form-control" required>
            </div>

            <input type="submit" class="btn btn-primary" name="submitQuestionnaire" value="{l s='Envoyer' mod='questionnairesante'}">
        </fieldset>
    </form>
</div>
