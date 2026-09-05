<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterLink;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a list of footer links
     */
    public function index()
    {
        $footerLinks = FooterLink::orderBy('column')
            ->orderBy('position')
            ->get()
            ->groupBy('column');
            
        return view('admin.footer.index', compact('footerLinks'));
    }

    /**
     * Show the form for creating a new footer link
     */
    public function create()
    {
        return view('admin.footer.create');
    }

    /**
     * Store a newly created footer link
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'column' => 'required|string|max:50',
            'position' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        // Set the is_active value correctly based on checkbox
        $validated['is_active'] = isset($validated['is_active']) ? true : false;

        FooterLink::create($validated);

        return redirect()->route('admin.footer.index')
            ->with('success', 'Footer bağlantısı başarıyla eklendi.');
    }

    /**
     * Show the form for editing a footer link
     */
    public function edit(FooterLink $footerLink)
    {
        return view('admin.footer.edit', compact('footerLink'));
    }

    /**
     * Update the specified footer link
     */
    public function update(Request $request, FooterLink $footerLink)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'column' => 'required|string|max:50',
            'position' => 'required|integer|min:0',
            'is_active' => 'boolean'
        ]);

        // Set the is_active value correctly based on checkbox
        $validated['is_active'] = isset($validated['is_active']) ? true : false;

        $footerLink->update($validated);

        return redirect()->route('admin.footer.index')
            ->with('success', 'Footer bağlantısı başarıyla güncellendi.');
    }

    /**
     * Remove the specified footer link
     */
    public function destroy(FooterLink $footerLink)
    {
        $footerLink->delete();

        return redirect()->route('admin.footer.index')
            ->with('success', 'Footer bağlantısı başarıyla silindi.');
    }
    
    /**
     * Update the footer company info
     */
    public function companyInfo(Request $request)
    {
        $validated = $request->validate([
            'footer_company_name' => 'required|string|max:255',
            'footer_company_description' => 'nullable|string',
            'footer_contact_heading' => 'nullable|string|max:255',
            'footer_contact_email' => 'required|email',
            'footer_contact_email_icon' => 'nullable|string|max:50',
            'footer_contact_phone' => 'nullable|string|max:20',
            'footer_contact_phone_icon' => 'nullable|string|max:50',
            'footer_contact_address' => 'nullable|string',
            'footer_contact_address_icon' => 'nullable|string|max:50',
            'footer_copyright_text' => 'nullable|string',
        ]);
        
        // Save footer settings to config
        $settings = [
            'footer' => [
                'company_name' => $validated['footer_company_name'],
                'company_description' => $validated['footer_company_description'],
                'contact_heading' => $validated['footer_contact_heading'],
                'contact_email' => $validated['footer_contact_email'],
                'contact_email_icon' => $validated['footer_contact_email_icon'] ?? 'fa-envelope',
                'contact_phone' => $validated['footer_contact_phone'],
                'contact_phone_icon' => $validated['footer_contact_phone_icon'] ?? 'fa-phone',
                'contact_address' => $validated['footer_contact_address'],
                'contact_address_icon' => $validated['footer_contact_address_icon'] ?? 'fa-map-marker-alt',
                'copyright_text' => $validated['footer_copyright_text'],
            ]
        ];
        
        $this->updateConfigFile('site.php', $settings);
        
        return redirect()->route('admin.footer.index')
            ->with('success', 'Footer şirket bilgileri başarıyla güncellendi.');
    }
    
    /**
     * Update the config file
     */
    private function updateConfigFile($filename, $newSettings)
    {
        $configPath = config_path($filename);
        
        if (file_exists($configPath)) {
            // Read the current config
            $currentConfig = include($configPath);
            
            // Merge with new settings - use array_replace_recursive instead of array_merge_recursive
            // to prevent creating nested arrays for the same keys
            $mergedConfig = array_replace_recursive($currentConfig ?: [], $newSettings);
            
            // Format as PHP array
            $configContent = "<?php\n\nreturn " . var_export($mergedConfig, true) . ";\n";
            
            // Write to the config file
            file_put_contents($configPath, $configContent);
        } else {
            // Create new config file
            $configContent = "<?php\n\nreturn " . var_export($newSettings, true) . ";\n";
            file_put_contents($configPath, $configContent);
        }
    }
}
