<?php

namespace App\Http\Controllers;

use App\Models\{EducationalContent, Category, Campaign};
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredContents = EducationalContent::published()
            ->featured()
            ->with('category', 'author')
            ->latest()
            ->take(6)
            ->get();

        $categories = Category::active()
            ->withCount('contents')
            ->ordered()
            ->get();

        // Get featured campaigns first, then fill with regular active campaigns if needed
        $featuredCampaigns = Campaign::active()
            ->featured()
            ->latest()
            ->take(3)
            ->get();

        $activeCampaigns = $featuredCampaigns;

        // If no featured campaigns or need more, get regular active campaigns
        if ($activeCampaigns->count() < 3) {
            $additionalCampaigns = Campaign::active()
                ->where('is_featured', false)
                ->latest()
                ->take(3 - $activeCampaigns->count())
                ->get();
            
            $activeCampaigns = $activeCampaigns->merge($additionalCampaigns);
        }

        return view('public.home', compact('featuredContents', 'categories', 'activeCampaigns'));
    }
}