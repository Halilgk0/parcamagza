<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class EmailTemplateController extends Controller
{
    /**
     * Controller constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    
    /**
     * Tüm e-posta temalarını listele
     */
    public function index()
    {
        $templates = EmailTemplate::orderBy('created_at', 'desc')->get();
        return view('admin.email-templates.index', compact('templates'));
    }

    /**
     * Yeni tema oluşturma formunu göster
     */
    public function create()
    {
        return view('admin.email-templates.create');
    }

    /**
     * Yeni tema oluştur
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // is_active değeri gelmiyorsa false olarak ayarla
        $validated['is_active'] = $request->has('is_active');

        EmailTemplate::create($validated);

        return redirect()->route('admin.email-templates.index')
            ->with('success', 'E-posta teması başarıyla oluşturuldu.');
    }

    /**
     * Tema düzenleme formunu göster
     */
    public function edit(EmailTemplate $emailTemplate)
    {
        return view('admin.email-templates.edit', compact('emailTemplate'));
    }

    /**
     * Temayı güncelle
     */
    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // is_active değeri gelmiyorsa false olarak ayarla
        $validated['is_active'] = $request->has('is_active');

        $emailTemplate->update($validated);

        return redirect()->route('admin.email-templates.index')
            ->with('success', 'E-posta teması başarıyla güncellendi.');
    }

    /**
     * Temayı sil
     */
    public function destroy(EmailTemplate $emailTemplate)
    {
        $emailTemplate->delete();

        return redirect()->route('admin.email-templates.index')
            ->with('success', 'E-posta teması başarıyla silindi.');
    }
    
    /**
     * E-posta temasını JSON olarak döndür
     */
    public function getData(EmailTemplate $emailTemplate)
    {
        return response()->json([
            'id' => $emailTemplate->id,
            'name' => $emailTemplate->name,
            'subject' => $emailTemplate->subject,
            'body' => $emailTemplate->body,
        ]);
    }
    
    /**
     * Hazır e-posta şablonları oluştur
     */
    public function seedSampleTemplates()
    {
        // Önceden oluşturulmuş şablonları temizleme seçeneği
        // EmailTemplate::truncate();
        
        // Şablon 1: Kampanya Fırsatları
        EmailTemplate::create([
            'name' => 'Kampanya Fırsatları',
            'subject' => 'Bahar İndirimi Başladı! %20\'ye Varan İndirimler Sizi Bekliyor',
            'description' => 'Kampanya duyuruları için kullanılabilecek bir şablon.',
            'is_active' => true,
            'body' => '
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; color: #333;">
                <div style="background-color: #1e3a8a; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0;">
                    <h1 style="margin: 0; font-size: 24px;">🚗 KAMPANYA FIRSATLARI</h1>
                </div>
                
                <div style="background-color: #f8f9fa; padding: 20px; border-left: 1px solid #ddd; border-right: 1px solid #ddd;">
                    <h2 style="color: #1e3a8a; margin-top: 0;">🚘 Bahar İndirimi Başladı!</h2>
                    <p style="font-size: 16px; line-height: 1.5;">%20\'ye varan indirim fırsatlarını kaçırmayın</p>
                    
                    <p style="font-size: 16px; line-height: 1.5;">Sayın {ad},</p>
                    
                    <p style="font-size: 16px; line-height: 1.5;">En çok ihtiyaç duyulan otomotiv parçalarında özel kampanyalar sizleri bekliyor! Sınırlı süre için geçerli bu fırsatları kaçırmayın.</p>
                    
                    <div style="margin: 30px 0; background: white; padding: 15px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 80px; vertical-align: top;">
                                    <img src="https://via.placeholder.com/80" alt="Fren Balatası" style="border-radius: 5px;">
                                </td>
                                <td style="padding-left: 15px; vertical-align: top;">
                                    <h3 style="margin-top: 0; margin-bottom: 5px; color: #1e3a8a;">Fren Balatası Seti</h3>
                                    <p style="margin-top: 0; color: #666;">%20 indirimle sadece 399 TL</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div style="margin: 20px 0; background: white; padding: 15px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 80px; vertical-align: top;">
                                    <img src="https://via.placeholder.com/80" alt="Yağ Filtresi" style="border-radius: 5px;">
                                </td>
                                <td style="padding-left: 15px; vertical-align: top;">
                                    <h3 style="margin-top: 0; margin-bottom: 5px; color: #1e3a8a;">Yağ Filtresi</h3>
                                    <p style="margin-top: 0; color: #666;">Sadece 89 TL - Hemen Al!</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div style="text-align: center; margin: 30px 0;">
                        <a href="{site_url}/kampanyalar" style="background-color: #e31837; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">Kampanyayı İncele</a>
                    </div>
                </div>
                
                <div style="background-color: #f1f1f1; padding: 15px; font-size: 12px; text-align: center; color: #666; border-radius: 0 0 5px 5px; border: 1px solid #ddd; border-top: none;">
                    <p>Bu e-posta, {site_adi} tarafından gönderilmiştir. E-posta bildirimlerini <a href="{site_url}/profile" style="color: #1e3a8a;">buradan</a> kapatabilirsiniz.</p>
                </div>
            </div>'
        ]);
        
        // Şablon 2: Hoş Geldiniz E-postası
        EmailTemplate::create([
            'name' => 'Hoş Geldiniz',
            'subject' => '{site_adi}\'na Hoş Geldiniz!',
            'description' => 'Yeni kullanıcılara gönderilecek hoş geldiniz mesajı.',
            'is_active' => true,
            'body' => '
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; color: #333;">
                <div style="background-color: #1e3a8a; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0;">
                    <h1 style="margin: 0; font-size: 24px;">Hoş Geldiniz!</h1>
                </div>
                
                <div style="background-color: #f8f9fa; padding: 20px; border-left: 1px solid #ddd; border-right: 1px solid #ddd;">
                    <h2 style="color: #1e3a8a; margin-top: 0;">Merhaba {ad},</h2>
                    
                    <p style="font-size: 16px; line-height: 1.5;">
                        {site_adi}\'na hoş geldiniz! Üyeliğinizi başarıyla tamamladınız.
                    </p>
                    
                    <p style="font-size: 16px; line-height: 1.5;">
                        Artık Türkiye\'nin en güvenilir otomotiv yedek parça platformunda alışveriş yapabilir,
                        binlerce parçaya özel fiyatlarla ulaşabilirsiniz.
                    </p>
                    
                    <div style="background-color: #e6f7ff; border-left: 4px solid #1e88e5; padding: 15px; margin: 20px 0;">
                        <p style="margin: 0; font-size: 16px;">
                            <strong>Üyelik Bilgileriniz:</strong><br>
                            E-posta: {email}<br>
                            Üyelik Tarihi: ' . date('d.m.Y') . '
                        </p>
                    </div>
                    
                    <h3 style="color: #1e3a8a;">Size Özel Avantajlar:</h3>
                    
                    <ul style="font-size: 16px; line-height: 1.5;">
                        <li>Binlerce parçaya hızlı erişim</li>
                        <li>Özel kampanya ve indirimlerden haberdar olma</li>
                        <li>Ücretsiz kargo fırsatları</li>
                        <li>7/24 müşteri desteği</li>
                    </ul>
                    
                    <div style="text-align: center; margin: 30px 0;">
                        <a href="{site_url}" style="background-color: #1e3a8a; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">Alışverişe Başla</a>
                    </div>
                </div>
                
                <div style="background-color: #f1f1f1; padding: 15px; font-size: 12px; text-align: center; color: #666; border-radius: 0 0 5px 5px; border: 1px solid #ddd; border-top: none;">
                    <p>Bu e-posta, {site_adi} tarafından gönderilmiştir. E-posta bildirimlerini <a href="{site_url}/profile" style="color: #1e3a8a;">buradan</a> kapatabilirsiniz.</p>
                </div>
            </div>'
        ]);
        
        // Şablon 3: Sipariş Onayı
        EmailTemplate::create([
            'name' => 'Sipariş Onayı',
            'subject' => 'Siparişiniz Onaylandı - Sipariş #{order_id}',
            'description' => 'Müşterilere sipariş onaylarını bildirmek için kullanılır.',
            'is_active' => true,
            'body' => '
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; color: #333;">
                <div style="background-color: #2e7d32; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0;">
                    <h1 style="margin: 0; font-size: 24px;">✅ Siparişiniz Onaylandı</h1>
                </div>
                
                <div style="background-color: #f8f9fa; padding: 20px; border-left: 1px solid #ddd; border-right: 1px solid #ddd;">
                    <h2 style="color: #2e7d32; margin-top: 0;">Değerli {ad},</h2>
                    
                    <p style="font-size: 16px; line-height: 1.5;">
                        Siparişiniz başarıyla alındı ve işleme konuldu. Siparişinizle ilgili detayları aşağıda bulabilirsiniz.
                    </p>
                    
                    <div style="background-color: #f5f5f5; border-radius: 5px; padding: 15px; margin: 20px 0;">
                        <h3 style="margin-top: 0; color: #2e7d32;">Sipariş Bilgileri:</h3>
                        <p style="margin-bottom: 5px;"><strong>Sipariş Numarası:</strong> #{order_id}</p>
                        <p style="margin-bottom: 5px;"><strong>Sipariş Tarihi:</strong> ' . date('d.m.Y H:i') . '</p>
                        <p style="margin-bottom: 5px;"><strong>Ödeme Yöntemi:</strong> Kredi Kartı</p>
                        <p style="margin-bottom: 0;"><strong>Sipariş Durumu:</strong> <span style="color: #2e7d32; font-weight: bold;">Onaylandı</span></p>
                    </div>
                    
                    <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                        <tr style="background-color: #2e7d32; color: white;">
                            <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Ürün</th>
                            <th style="padding: 10px; text-align: center; border: 1px solid #ddd;">Adet</th>
                            <th style="padding: 10px; text-align: right; border: 1px solid #ddd;">Fiyat</th>
                        </tr>
                        <tr style="background-color: #fff;">
                            <td style="padding: 10px; text-align: left; border: 1px solid #ddd;">Örnek Ürün 1</td>
                            <td style="padding: 10px; text-align: center; border: 1px solid #ddd;">1</td>
                            <td style="padding: 10px; text-align: right; border: 1px solid #ddd;">299.90 TL</td>
                        </tr>
                        <tr style="background-color: #f9f9f9;">
                            <td style="padding: 10px; text-align: left; border: 1px solid #ddd;">Örnek Ürün 2</td>
                            <td style="padding: 10px; text-align: center; border: 1px solid #ddd;">2</td>
                            <td style="padding: 10px; text-align: right; border: 1px solid #ddd;">89.90 TL</td>
                        </tr>
                        <tr style="background-color: #f5f5f5;">
                            <td colspan="2" style="padding: 10px; text-align: right; border: 1px solid #ddd;"><strong>Ara Toplam:</strong></td>
                            <td style="padding: 10px; text-align: right; border: 1px solid #ddd;">479.70 TL</td>
                        </tr>
                        <tr style="background-color: #f5f5f5;">
                            <td colspan="2" style="padding: 10px; text-align: right; border: 1px solid #ddd;"><strong>Kargo:</strong></td>
                            <td style="padding: 10px; text-align: right; border: 1px solid #ddd;">29.90 TL</td>
                        </tr>
                        <tr style="background-color: #f5f5f5;">
                            <td colspan="2" style="padding: 10px; text-align: right; border: 1px solid #ddd;"><strong>Toplam:</strong></td>
                            <td style="padding: 10px; text-align: right; border: 1px solid #ddd; font-weight: bold;">509.60 TL</td>
                        </tr>
                    </table>
                    
                    <div style="text-align: center; margin: 30px 0;">
                        <a href="{site_url}/profile/orders/{order_id}" style="background-color: #2e7d32; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">Siparişi Görüntüle</a>
                    </div>
                    
                    <p style="font-size: 16px; line-height: 1.5;">
                        Siparişinizle ilgili herhangi bir sorunuz varsa, <a href="mailto:info@parcamagaza.com" style="color: #1e3a8a;">info@parcamagaza.com</a> adresinden bizimle iletişime geçebilirsiniz.
                    </p>
                </div>
                
                <div style="background-color: #f1f1f1; padding: 15px; font-size: 12px; text-align: center; color: #666; border-radius: 0 0 5px 5px; border: 1px solid #ddd; border-top: none;">
                    <p>Bu e-posta, {site_adi} tarafından gönderilmiştir. E-posta bildirimlerini <a href="{site_url}/profile" style="color: #1e3a8a;">buradan</a> kapatabilirsiniz.</p>
                </div>
            </div>'
        ]);
        
        // Şablon 4: İndirim Kuponu
        EmailTemplate::create([
            'name' => 'İndirim Kuponu',
            'subject' => 'Size Özel %15 İndirim Kuponu 🎁',
            'description' => 'Müşterilere özel indirim kuponları göndermek için kullanılır.',
            'is_active' => true,
            'body' => '
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; color: #333;">
                <div style="background-color: #9c27b0; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0;">
                    <h1 style="margin: 0; font-size: 24px;">🎁 Size Özel İndirim Kuponu</h1>
                </div>
                
                <div style="background-color: #f8f9fa; padding: 20px; border-left: 1px solid #ddd; border-right: 1px solid #ddd;">
                    <h2 style="color: #9c27b0; margin-top: 0;">Değerli {ad},</h2>
                    
                    <p style="font-size: 16px; line-height: 1.5;">
                        Sizin için özel bir indirim kuponumuz var! İlk alışverişinizde geçerli %15 indirim kuponu.
                    </p>
                    
                    <div style="margin: 30px auto; background: linear-gradient(135deg, #9c27b0 0%, #673ab7 100%); color: white; padding: 20px; border-radius: 10px; text-align: center; box-shadow: 0 4px 8px rgba(0,0,0,0.2); max-width: 300px;">
                        <h3 style="margin-top: 0; font-size: 18px;">KUPON KODU</h3>
                        <div style="background-color: rgba(255,255,255,0.9); color: #9c27b0; padding: 10px; border-radius: 5px; font-size: 24px; font-weight: bold; letter-spacing: 2px;">
                            HOSGELDIN15
                        </div>
                        <p style="margin-bottom: 0; font-size: 14px; margin-top: 10px;">
                            <strong>Son Kullanma:</strong> ' . date('d.m.Y', strtotime('+30 days')) . '
                        </p>
                    </div>
                    
                    <ul style="font-size: 16px; line-height: 1.5;">
                        <li>Tüm ürünlerde geçerlidir</li>
                        <li>Minimum sipariş tutarı: 200 TL</li>
                        <li>Diğer indirimlerle birleştirilemez</li>
                        <li>Son kullanma tarihi: ' . date('d.m.Y', strtotime('+30 days')) . '</li>
                    </ul>
                    
                    <div style="text-align: center; margin: 30px 0;">
                        <a href="{site_url}" style="background-color: #9c27b0; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">Hemen Alışverişe Başla</a>
                    </div>
                </div>
                
                <div style="background-color: #f1f1f1; padding: 15px; font-size: 12px; text-align: center; color: #666; border-radius: 0 0 5px 5px; border: 1px solid #ddd; border-top: none;">
                    <p>Bu e-posta, {site_adi} tarafından gönderilmiştir. E-posta bildirimlerini <a href="{site_url}/profile" style="color: #1e3a8a;">buradan</a> kapatabilirsiniz.</p>
                </div>
            </div>'
        ]);
        
        // Şablon 5: Stok Bildirimi
        EmailTemplate::create([
            'name' => 'Stok Bildirimi',
            'subject' => 'Stok Uyarısı: {urun_adi}',
            'description' => 'Ürün stokları azaldığında veya tükendiğinde gönderilen bildirim.',
            'is_active' => true,
            'body' => '
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; color: #333;">
                <div style="background-color: #dc3545; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0;">
                    <h1 style="margin: 0; font-size: 24px;">⚠️ Stok Uyarısı</h1>
                </div>
                
                <div style="background-color: #f8f9fa; padding: 20px; border-left: 1px solid #ddd; border-right: 1px solid #ddd;">
                    <h2 style="color: #1e3a8a; margin-top: 0;">Ürün: {urun_adi}</h2>
                    
                    <div style="background-color: #e6f7ff; border-left: 4px solid #1e88e5; padding: 15px; margin: 20px 0;">
                        <p style="margin: 0; font-size: 16px;">
                            <strong>Ürün Bilgileri:</strong><br>
                            Parça Numarası: {parca_numarasi}<br>
                            Kategori: {kategori}<br>
                            Stok Durumu: {stok_durumu}
                        </p>
                    </div>
                    
                    <p style="font-size: 16px; line-height: 1.5;">
                        Bu ürün için stok güncellenmesi gerekiyor. Aşağıdaki düğmeyi kullanarak ürün stok ayarlarını güncelleyebilirsiniz.
                    </p>
                    
                    <div style="text-align: center; margin: 30px 0;">
                        <a href="{urun_url}" style="background-color: #1e3a8a; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">Ürün Stok Ayarlarını Güncelle</a>
                    </div>
                </div>
                
                <div style="background-color: #f1f1f1; padding: 15px; font-size: 12px; text-align: center; color: #666; border-radius: 0 0 5px 5px; border: 1px solid #ddd; border-top: none;">
                    <p>Bu e-posta, {site_adi} tarafından otomatik olarak gönderilmiştir.</p>
                </div>
            </div>'
        ]);
        
        return redirect()->route('admin.email-templates.index')
            ->with('success', 'Örnek e-posta şablonları başarıyla oluşturuldu.');
    }
} 