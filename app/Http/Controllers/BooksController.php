<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Books;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;

class BooksController extends Controller
{
    //
    public function getAllBooks() {
        // logic to get all Bookss goes here
    //     $books = Books::get()->toJson(JSON_PRETTY_PRINT);
    // return response($books, 200);
    
    $client = new Client((['base_uri' => 'https://www.anapioficeandfire.com/api/']));
       
    $response = $client->request('GET', 'books');
    // return response([
    //     'status_code' => $response->getStatusCode(),
    //      'status' => "success",
    //      'data' => $response->getBody()->getContents() ]);
     $output = json_decode($response->getBody()->getContents());
    
            $newdata = array();
            $count = count($output);
    for ($x = 0; $x < $count ; $x++) {
       $newdata[] =  array(
           "id" => $x + 1,
           "name" => $output[$x]->name,
           "isbn" => $output[$x]->isbn,
           "authors" => $output[$x]->authors,
           "number_of_pages" => $output[$x]->numberOfPages,
           "publisher" => $output[$x]->publisher,
           "country" => $output[$x]->country,
           "release_date" => $output[$x]->released,
        );
       
    }
    
    // return $newdata;
     return response([
        'status_code' => $response->getStatusCode(),
         'status' => "success",
         'data' => $newdata 
        ]);
    
    
      }
  
      public function createBook(Request $request) {
        // logic to create a Books record goes here
        $book = new Books;
      $book->name = $request->name;
      $book->isbn = $request->isbn;
      $book->authors = $request->authors;
      $book->number_of_pages = $request->number_of_pages;
      $book->country = $request->country;
      $book->publisher = $request->publisher;
      $book->release_date = $request->release_date;
      $book->save();

      return response()->json([
        "status_code" => 201,
        "status" => "success",
        "data" => $book
      ], 201);
      }
  
      public function getBook($id) {
        // logic to get a Books record goes here

        if (Books::where('id', $id)->exists()) {
            $Book = Books::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($Book, 200);
          } else {
            return response()->json([
              "message" => "Book not found"
            ], 404);
          }
      }
  
      public function updateBook(Request $request, $id) {
        // logic to update a Books record goes here
        if (Books::where('id', $id)->exists()) {
            $Book = Books::find($id);
    
            $Book->name = is_null($request->name) ? $Book->name : $request->name;
            $Book->isbn = is_null($request->isbn) ? $Book->isbn : $request->isbn;
            $Book->authors = is_null($request->authors) ? $Book->authors : $request->authors;
            $Book->number_of_pages = is_null($request->number_of_pages) ? $Book->number_of_pages : $request->number_of_pages;
            $Book->country = is_null($request->country) ? $Book->country : $request->country;
            $Book->publisher = is_null($request->publisher) ? $Book->publisher : $request->publisher;
            $Book->release_date = is_null($request->release_date) ? $Book->release_date : $request->release_date;
           
            $Book->save();
    
            return response()->json([
                "status_code" => 200,
                "status" => "success",
                "message" => "The book was updated successfully",
            ], 200);
          } else {
            return response()->json([
              "message" => "Book not found"
            ], 404);
          }
      }
  
      public function deleteBook ($id) {
        // logic to delete a Books record goes here
        if(Books::where('id', $id)->exists()) {
            $Books = Books::find($id);
            $Books->delete();
    
            return response()->json([
                "status_code" => 200,
                "status" => "success",
                "message" => "The book was deleted successfully",
                "data" => []
            ], 202);
          } else {
            return response()->json([
              "message" => "Book not found"
            ], 404);
          }
        }
      
}
