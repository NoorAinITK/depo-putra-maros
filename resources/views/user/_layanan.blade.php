<div class="choice-card">
    <label>
        <span class="ic">🏠</span>Pick up<br>
        <input type="radio" name="service_method" value="pickup" @checked(old('service_method', 'pickup') === 'pickup')>
    </label>
    <label>
        <span class="ic">🛵</span>Delivery<br>
        <input type="radio" name="service_method" value="delivery" @checked(old('service_method') === 'delivery')>
    </label>
</div>
