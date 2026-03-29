<?php

namespace App\Http\Controllers;

use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class StaticPageController extends Controller
{
  private array $pages = [
        'about-us'       => 'About Us',
        'why-us'         => 'Why Us',
        'chat-with-us'   => 'Chat With Us',
        'animal-welfare' => 'Animal Welfare',
    ];

    public function index()
    {
        $pages = collect($this->pages)->map(fn($label, $slug) => [
            'slug'  => $slug,
            'label' => $label,
            'page'  => StaticPage::findBySlug($slug),
        ]);

        return view('admin.static-pages.index', compact('pages'));
    }

    public function edit(string $slug)
    {
        abort_unless(array_key_exists($slug, $this->pages), 404);
        $page  = StaticPage::findBySlug($slug);
        $label = $this->pages[$slug];
        return view('admin.static-pages.edit', compact('page', 'slug', 'label'));
    }

    public function update(Request $request, string $slug)
    {
        abort_unless(array_key_exists($slug, $this->pages), 404);

        $page = StaticPage::findBySlug($slug);

        // Hero image upload
        $heroImage = $page->hero_image;
        if ($request->hasFile('hero_image')) {
            if ($heroImage) Storage::disk('public')->delete($heroImage);
            $heroImage = $request->file('hero_image')->store('static-pages', 'public');
        }

        // Parse sections JSON from textarea
        $sections = $request->input('sections_json')
            ? json_decode($request->input('sections_json'), true)
            : $page->sections;

        $stats = $request->input('stats_json')
            ? json_decode($request->input('stats_json'), true)
            : $page->stats;

        $page->update([
            'hero_title'      => $request->input('hero_title'),
            'hero_subtitle'   => $request->input('hero_subtitle'),
            'hero_tag'        => $request->input('hero_tag'),
            'hero_image'      => $heroImage,
            'sections'        => $sections,
            'stats'           => $stats,
            'cta_title'       => $request->input('cta_title'),
            'cta_subtitle'    => $request->input('cta_subtitle'),
            'cta_button_text' => $request->input('cta_button_text'),
            'cta_button_url'  => $request->input('cta_button_url'),
        ]);

        return redirect()->route('admin.static-pages.edit', $slug)
            ->with('success', "{$this->pages[$slug]} updated successfully.");
    }
}
