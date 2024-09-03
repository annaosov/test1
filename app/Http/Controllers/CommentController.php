<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'companyId' => 'bail|required|integer|exists:companies,id',
            'userId' => 'bail|required|integer|exists:users,id',
        ]);
        Comment::create([
            'company_id' => $request->companyId,
            'field_name' => $request->name ? 'name' : ($request->inn ? 'inn' : ($request->info ? 'info' : ($request->CEO ? 'CEO' : ($request->address ? 'address' : ($request->phone ? 'phone' : ($request->general ? 'general' : $request->validate(['text_comment' => 'required']))))))),
            'text_comment' => $request->name ? $request->name : ($request->inn ? $request->inn : ($request->info ? $request->info : ($request->CEO ? $request->CEO : ($request->address ? $request->address : ($request->phone ? $request->phone : ($request->general ? $request->general : $request->validate(['text_comment' => 'required']))))))),
            'user_id' => $request->userId,
        ]);

        return back()->with('message', 'Комментарий успешно добавлен');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if($company = Company::find($id)) {
            $comments = Comment::where('company_id', $id)->get();

            foreach ($comments as $i => $comment) {
                $comments[$i]['user_name'] = $comment->user->name;
            }
    
            return Inertia::render(
                'Company/View',
                [
                    'company' => $company,
                    'comments' => $comments
                ]
            );
        }
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
