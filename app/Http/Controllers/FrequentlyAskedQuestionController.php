<?php

namespace App\Http\Controllers;

use App\FrequentlyAskedQuestion;
use Illuminate\Http\Request;
use View;
use Illuminate\Support\Facades\Auth;


class FrequentlyAskedQuestionController extends Controller
{
    public function __construct()
    {
		$this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
            $roles = json_decode(Auth::user()->user_role, 1);
            if (!isset($roles) || empty($roles) || !in_array('frequently asked questions', $roles)) {
                echo "You don't have permission to freequently asked questions.";
                die;
            }    
        $faqs = FrequentlyAskedQuestion::take(20)->latest()->get();
        
        return view('admin.faqs.index', [
            'faqs' => $faqs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $roles = json_decode(Auth::user()->user_role, 1);
            if (!isset($roles) || empty($roles) || !in_array('frequently asked questions', $roles)) {
                echo "You don't have permission to freequently asked questions.";
                die;
            }
        return view('admin.faqs.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return [type]
     */
    public function store(Request $request)
    {
        $roles = json_decode(Auth::user()->user_role, 1);
            if (!isset($roles) || empty($roles) || !in_array('frequently asked questions', $roles)) {
                echo "You don't have permission to freequently asked questions.";
                die;
            }
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'categories' => 'sometimes|required|array',
        ]);
        
        if ($request->missing('categories')) {
            $validatedData['categories'] = [];
        }

        FrequentlyAskedQuestion::create($validatedData);

        return redirect()->route('frequently-asked-questions.index')->with('status', 'FAQ added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FrequentlyAskedQuestion  $frequentlyAskedQuestion
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(FrequentlyAskedQuestion $frequentlyAskedQuestion)
    {
        $roles = json_decode(Auth::user()->user_role, 1);
            if (!isset($roles) || empty($roles) || !in_array('frequently asked questions', $roles)) {
                echo "You don't have permission to freequently asked questions.";
                die;
            }
        return view('admin.faqs.form', ['faq' => $frequentlyAskedQuestion]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FrequentlyAskedQuestion  $frequentlyAskedQuestion
     * @return [type]
     */
    public function update(Request $request, FrequentlyAskedQuestion $frequentlyAskedQuestion)
    {
        $roles = json_decode(Auth::user()->user_role, 1);
            if (!isset($roles) || empty($roles) || !in_array('frequently asked questions', $roles)) {
                echo "You don't have permission to freequently asked questions.";
                die;
            }
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'categories' => 'sometimes|required|array',
        ]);

        if ($request->missing('categories')) {
            $validatedData['categories'] = [];
        }

        $frequentlyAskedQuestion->update($validatedData);

        return redirect()->route('frequently-asked-questions.index')->with('status', 'FAQ updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FrequentlyAskedQuestion  $frequentlyAskedQuestion
     * @return [type]
     */
    public function destroy(FrequentlyAskedQuestion $frequentlyAskedQuestion)
    {
        $roles = json_decode(Auth::user()->user_role, 1);
            if (!isset($roles) || empty($roles) || !in_array('frequently asked questions', $roles)) {
                echo "You don't have permission to freequently asked questions.";
                die;
            }
        $frequentlyAskedQuestion->delete();

		return redirect()->route('frequently-asked-questions.index')->with('status', 'FAQ deleted successfully');
    }

    /**
     * Display result of the search query
     *
     * @param  \Illuminate\Http\Request  $request
     * @return [type]
     */
    public function search(Request $request)
    {
        $faqs = FrequentlyAskedQuestion::where('title', 'like', '%'.$request->input('query').'%')->take(20)->latest()->get();
        $html = View::make('admin.faqs.table', ['faqs' => $faqs]);
        $response = $html->render();

        return response()->json([
            'status' => 'success',
            'html' => $response
        ]); 
    }

    /**
     * Display result of category search query
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function categories(Request $request)
    {
        $faqs = FrequentlyAskedQuestion::where('categories', 'like', '%'.$request->input('query').'%')->take(20)->latest()->get();
        $categories = array();
        $transformedCategories = array();

        $faqs->each(function($item, $key) use ($request, &$categories) {
            foreach ($item->categories as $category) {
                if (str_contains($category, $request->input('query')) && !in_array($category, $categories)) {
                    array_push($categories, $category);
                }
            }
        });

        foreach ($categories as $category) {
            array_push($transformedCategories, [
                'text' => $category,
                'value' => $category
            ]);
        }

        return $transformedCategories;
    }
}
