
<style>
    html, body {
  height: 100%;
  margin: 0;
  padding: 0;
}

body {
  display: flex;
  justify-content: center;
  align-items: center;
}

form {
  width: 400px; /* Ajustez la largeur selon vos besoins */
  /* Ajoutez d'autres styles de mise en forme pour le formulaire */
}
</style>

<form action="{{ route('api.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @csrf <!-- Ajout du jeton CSRF -->
  
    <label for="title">Titre :</label>
    <input type="text" name="title" id="title" value="{{ $product->title }}" required><br>
  
    <label for="description">Description :</label>
    <textarea name="description" id="description" required>{{ $product->description }}</textarea><br>
  
    <label for="price">Prix :</label>
    <input type="number" name="price" id="price" value="{{ $product->price }}" required><br>
  
    <label for="country">Pays :</label>
    <input type="text" name="country" id="country" value="{{ $product->country }}" required><br>
  
    <label for="city">Ville :</label>
    <input type="text" name="city" id="city" value="{{ $product->city }}" required><br>
  
    <label for="district">Quartier :</label>
    <input type="text" name="district" id="district" value="{{ $product->district }}" required><br>
  
    <label for="surface_area">Surface :</label>
    <input type="number" name="surface_area" id="surface_area" value="{{ $product->surface_area }}" required><br>
  
    <label for="image">Changer les images :</label>
    <input type="file" name="image[]" id="image" multiple><br>
  
    <label for="type">Type :</label>
    <select name="type" id="type" required>
        <option value="appartement" @if ($product->type === 'appartement') selected @endif>Appartement</option>
        <option value="villa" @if ($product->type === 'villa') selected @endif>Villa</option>
        <option value="maison" @if ($product->type === 'maison') selected @endif>Maison</option>
        <option value="terrain" @if ($product->type === 'terrain') selected @endif>Terrain</option>
    </select><br>
  
    <label for="status">Statut :</label>
    <select name="status" id="status" required>
        <option value="vente" @if ($product->status === 'vente') selected @endif>En vente</option>
        <option value="location" @if ($product->status === 'location') selected @endif>En location</option>
    </select><br>
  
    <label for="no_rooms">Nombre de pièces :</label>
    <input type="number" name="no_rooms" id="no_rooms" min="0" value="{{ $product->no_rooms }}"><br>
  
    <label for="no_bedrooms">Nombre de chambres :</label>
    <input type="number" name="no_bedrooms" id="no_bedrooms" min="0" value="{{ $product->no_bedrooms }}"><br>
  
    <label for="no_bathrooms">Nombre de salles de bain :</label>
    <input type="number" name="no_bathrooms" id="no_bathrooms" min="0" value="{{ $product->no_bathrooms }}"><br>
  
    <label for="no_garages">Nombre de garages :</label>
    <input type="number" name="no_garages" id="no_garages" min="0" value="{{ $product->no_garages }}"><br>
  
    <input type="submit" value="Envoyer">
</form>
  

  