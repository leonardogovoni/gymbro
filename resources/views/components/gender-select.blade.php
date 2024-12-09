<select {{ $attributes->merge(['class' => 'block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500']) }}>
    <option value="" disabled {{ empty($attributes['value']) ? 'selected' : '' }}>Seleziona un sesso</option>
    <option value="M" {{ $attributes['value'] == 'M' ? 'selected' : '' }}>Uomo</option>
    <option value="F" {{ $attributes['value'] == 'F' ? 'selected' : '' }}>Donna</option>
    <option value="N" {{ $attributes['value'] == 'N' ? 'selected' : '' }}>Non Specificato</option>
</select>
