<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/products",
     *     tags={"Products"},
     *     summary="Obtenez tous les produits pour PMIFAPI",
     *     description="Les valeurs multiples peuvent être fournies avec une chaîne séparée par virgule",
     *     operationId="index",
     *     @OA\Response(
     *         response=200,
     *         description="opération réussie",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Valeur(s) non valide(s)"
     *     )
     * )
     */

    public function index() {

        return Product::orderBy('created_at', 'DESC')->get();
    }

    /**
     * @OA\Post(
     *     path="/api/product/add",
     *     tags={"Products"},
     *     summary="Créer un nouveau produit",
     *     description="Créer un nouveau produit avec les données fournies",
     *     operationId="store",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="title",
     *                     type="string",
     *                     example="Product Title"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     example="Product Description"
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     type="integer",
     *                     example=100
     *                 ),
     *                 @OA\Property(
     *                     property="country",
     *                     type="string",
     *                     example="Country"
     *                 ),
     *                 @OA\Property(
     *                     property="city",
     *                     type="string",
     *                     example="City"
     *                 ),
     *                 @OA\Property(
     *                     property="district",
     *                     type="string",
     *                     example="District"
     *                 ),
     *                 @OA\Property(
     *                     property="surface_area",
     *                     type="integer",
     *                     example=100
     *                 ),
     *                 @OA\Property(
     *                     property="image",
     *                     type="array",
     *                     @OA\Items(
     *                         type="string",
     *                         format="binary",
     *                         example="image1.jpg"
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="no_rooms",
     *                     type="integer",
     *                     example=2
     *                 ),
     *                 @OA\Property(
     *                     property="no_bedrooms",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="no_bathrooms",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="no_garages",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="type",
     *                     type="string",
     *                     example="appartement"
     *                 ),
     *                 @OA\Property(
     *                     property="status",
     *                     type="string",
     *                     example="vente"
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Produit créé avec succès",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Données non valides fournies"
     *     )
     * )
     */

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
            'country' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'surface_area' => 'required|integer',
            'image' => 'required|array',
            'image.*' => 'required|image|max:2048', // Chaque image peut avoir une taille maximale de 2048 Ko (2 Mo)
            'no_rooms' => 'nullable|integer',
            'no_bedrooms' => 'nullable|integer',
            'no_bathrooms' => 'nullable|integer',
            'no_garages' => 'nullable|integer',
            'type' => 'required|in:appartement,villa,maison,terrain',
            'status' => 'required|in:vente,location',
        ]);

        if ($validator->fails()) {
        
            if (!$request->hasFile('image')) {
                return "Le formulaire ne contient pas d'image";
            }
        
            return "La validation a échoué";
        }

        if ($request->hasFile('image')) {
            $images = [];
        
            foreach ($request->file('image') as $file) {
                $imageName = $file->store('product');
                $image = Image::make(public_path("storage/{$imageName}"))->fit(1200, 853);
                $image->save();
        
                $images[] = $imageName;
            }
        }
        
        $product = Product::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'country' => $request->country,
            'city' => $request->city,
            'district' => $request->district,
            'surface_area' => $request->surface_area,
            'image' => $images ?? null,
            'type' => $request->type,
            'status' => $request->status,
            'no_rooms' => $request->no_rooms,
            'no_bedrooms' => $request->no_bedrooms,
            'no_bathrooms' => $request->no_bathrooms,
            'no_garages' => $request->no_garages,
        ]);
    
        return $product;
    }

    /**
     * @OA\Get(
     *     path="/api/product/{id}",
     *     tags={"Products"},
     *     summary="Obtenir les détails du produit",
     *     description="Obtenez les détails d'un produit spécifique par son identifiant",
     *     operationId="getDetail",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Product ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             example="1"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Opération réussie",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produit non trouvé"
     *     )
     * )
     */
    public function getDetail($id)
    {
        $product = Product::findOrFail($id);

        return response()->json($product);
    }

    /**
     * @OA\Put(
     *     path="/api/product/update/{id}",
     *     tags={"Products"},
     *     summary="Mettre à jour un produit",
     *     description="Mettez à jour un produit existant avec les données fournies",
     *     operationId="update",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Product ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             example="1"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="title",
     *                     type="string",
     *                     example="Product Title Updated"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     example="Product Description Updated"
     *                 ),
     *                 @OA\Property(
     *                     property="price",
     *                     type="integer",
     *                     example="200"
     *                 ),
     *                 @OA\Property(
     *                     property="country",
     *                     type="string",
     *                     example="CountryUpdated"
     *                 ),
     *                 @OA\Property(
     *                     property="city",
     *                     type="string",
     *                     example="CityUpdated"
     *                 ),
     *                 @OA\Property(
     *                     property="district",
     *                     type="string",
     *                     example="DistrictUpdated"
     *                 ),
     *                 @OA\Property(
     *                     property="surface_area",
     *                     type="integer",
     *                     example="200"
     *                 ),
     *                 @OA\Property(
     *                     property="image",
     *                     type="array",
     *                     @OA\Items(type="string", example="imageupdated.jpg")
     *                 ),
     *                 @OA\Property(
     *                     property="no_rooms",
     *                     type="integer",
     *                     example="2"
     *                 ),
     *                 @OA\Property(
     *                     property="no_bedrooms",
     *                     type="integer",
     *                     example="2"
     *                 ),
     *                 @OA\Property(
     *                     property="no_bathrooms",
     *                     type="integer",
     *                     example="2"
     *                 ),
     *                 @OA\Property(
     *                     property="no_garages",
     *                     type="integer",
     *                     example="2"
     *                 ),
     *                 @OA\Property(
     *                     property="type",
     *                     type="string",
     *                     example="villa"
     *                 ),
     *                 @OA\Property(
     *                     property="status",
     *                     type="string",
     *                     example="location"
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produit mis a jour avec succès",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Données non valides fournies"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produit non trouvé"
     *     )
     * )
     */

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
            'country' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'surface_area' => 'required|integer',
            'image' => 'nullable|array',
            'image.*' => 'nullable|image|max:2048',
            'no_rooms' => 'nullable|integer',
            'no_bedrooms' => 'nullable|integer',
            'no_bathrooms' => 'nullable|integer',
            'no_garages' => 'nullable|integer',
            'type' => 'required|in:appartement,villa,maison,terrain',
            'status' => 'required|in:vente,location',
        ]);

        $arrayUpdate = [
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'country' => $request->country,
            'city' => $request->city,
            'district' => $request->district,
            'surface_area' => $request->surface_area,
            'no_rooms' => $request->no_rooms,
            'no_bedrooms' => $request->no_bedrooms,
            'no_bathrooms' => $request->no_bathrooms,
            'no_garages' => $request->no_garages,
            'type' => $request->type,
            'status' => $request->status,
        ];

        if ($request->hasFile('image')) {

            if (!empty($product->image)) {
                foreach ($product->image as $image) {
                    Storage::delete($image);
                }
            }
    
            $images = [];
    
            foreach ($request->file('image') as $file) {
                $imageName = $file->store('product');
                $image = Image::make(public_path("storage/{$imageName}"))->fit(1200, 853);
                $image->save();
    
                $images[] = $imageName;
            }
    
            $arrayUpdate['image'] = $images;
        }

        $product->update($arrayUpdate);

        return $product;
    }

    /**
     * @OA\Delete(
     *     path="/api/product/remove/{id}",
     *     tags={"Products"},
     *     summary="Supprimer un produit",
     *     description="Supprimer un produit existant par son identifiant",
     *     operationId="destroy",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Product ID",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             example="1"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produit supprimé avec succès",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produit non trouvé"
     *     )
     * )
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if (!empty($product->image)) {
            foreach ($product->image as $image) {
                Storage::delete($image);
            }
        }
    
        $product->delete();
    
        return response()->json('Product deleted successfully');
    }

}
