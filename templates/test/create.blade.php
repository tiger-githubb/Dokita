
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

table {
    width: 100%;
    max-width: 800px;
    border-collapse: collapse;
    margin: auto;
  }

  th, td {
    padding: 8px;
    border: 1px solid #ddd;
    text-align: left;
  }

  th {
    background-color: #f2f2f2;
  }

form {
  width: 400px; /* Ajustez la largeur selon vos besoins */
  /* Ajoutez d'autres styles de mise en forme pour le formulaire */
}
</style>


<form action="{{ route('api.product.add') }}" method="POST" enctype="multipart/form-data" style="margin-left:50px">
  @csrf <!-- Ajout du jeton CSRF -->

  <label for="title">Titre :</label>
  <input type="text" name="title" id="title" required><br>

  <label for="description">Description :</label>
  <textarea name="description" id="description" required></textarea><br>

  <label for="price">Prix :</label>
  <input type="number" name="price" id="price" required><br>

  <label for="country">Pays :</label>
  <input type="text" name="country" id="country" required><br>

  <label for="city">Ville :</label>
  <input type="text" name="city" id="city" required><br>

  <label for="district">Quartier :</label>
  <input type="text" name="district" id="district" required><br>

  <label for="surface_area">Surface :</label>
  <input type="number" name="surface_area" id="surface_area" required><br>

  <label for="image">Images :</label>
  <input type="file" name="image[]" id="image" multiple required><br>

  <label for="type">Type :</label>
  <select name="type" id="type" required>
      <option value="appartement">Appartement</option>
      <option value="villa">Villa</option>
      <option value="terrain">Terrain</option>
  </select><br>

  <label for="status">Statut :</label>
  <select name="status" id="status" required>
      <option value="vente">En vente</option>
      <option value="location">En location</option>
  </select><br>

  <label for="no_rooms">Nombre de pièces :</label>
  <input type="number" name="no_rooms" id="no_rooms" min="0"><br>

  <label for="no_bedrooms">Nombre de chambres :</label>
  <input type="number" name="no_bedrooms" id="no_bedrooms" min="0"><br>

  <label for="no_bathrooms">Nombre de salles de bain :</label>
  <input type="number" name="no_bathrooms" id="no_bathrooms" min="0"><br>

  <label for="no_garages">Nombre de garages :</label>
  <input type="number" name="no_garages" id="no_garages" min="0"><br>

  <input type="submit" value="Envoyer">
</form>

<table>
  <thead>
    <tr>
      <th>Titre</th>
      <th>Prix</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($products as $product)
    <tr>
      <td>{{ $product->title }}</td>
      <td>{{ $product->price }}</td>
      <td><a href="{{ route('edit', $product) }}">update</a> or <a href="{{ route('delete', $product->id) }}">delete</a></td>
    </tr>
    @endforeach
  </tbody>
</table>

  