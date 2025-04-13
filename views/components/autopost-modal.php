<div class="card" id="autopost-modal">
    <h3 class="section-header">Auto post</h3>
    <form action="">
        <fieldset id="step-1">
            <h4>Please, select an account to post</h4>
            <div class="form-line">
                <label for="account-spanish" class="card-selector">
                    <input type="radio" name="accounts" id="account-spanish" value="es" checked>
                    <div class="card-selector-content">
                        <span class="icon"><i class="material-icons">check_circle</i></span>
                        <h4>Facebook and Instagram Spanish</h4>
                    </div>
                </label>
                <label for="account-portuguese" class="card-selector">
                    <input type="radio" name="accounts" id="account-portuguese" value="pt" checked>
                    <div class="card-selector-content">
                        <span class="icon"><i class="material-icons">check_circle</i></span>
                        <h4>Facebook and Instagram Portuguese</h4>
                    </div>
                </label>
            </div>
            <div class="actions">
                <button type="button" class="button primary" onclick="changeStep('step-2')">Next</button>
            </div>
        </fieldset>
        <fieldset id="step-2" style="display:flex;">
            <h4>Please, select a caption:</h4>
            <div id="captions-list"></div>
            <div class="actions" style="justify-content: space-between;">
                <button type="button" class="button secondary" onclick="changeStep('step-1')">Previous</button>
                <button type="button" class="button primary" onclick="autoPostPublish()">Publish</button>
            </div>
        </fieldset>
        <fieldset id="step-3">
            <div style="display:flex; flex-direction:column; align-items:center; width:100%; height: 240px; justify-content:center;">
            <h3>Posting...</h3>
            <div class="loader"></div>
            </div>
        </fieldset>
    </form>
</div>