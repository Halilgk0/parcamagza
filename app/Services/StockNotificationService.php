<?php

namespace App\Services;

use App\Models\Part;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class StockNotificationService
{
    /**
     * Send a notification when stock is depleted for a part
     *
     * @param Part $part The part that has depleted stock
     * @return bool Whether the notification was sent successfully
     */
    public static function sendStockDepletedNotification(Part $part)
    {
        $notificationEmail = config('site.notification_email');
        
        // If no notification email is set, don't send anything
        if (empty($notificationEmail)) {
            Log::info('No notification email set for stock alerts');
            return false;
        }
        
        try {
            $siteName = config('app.name', 'Parca Magaza');
            
            // Check if we have a stock notification template
            $template = EmailTemplate::where('name', 'Stok Bildirimi')->where('is_active', true)->first();
            
            if ($template) {
                // Use the template with variables replaced
                $emailContent = str_replace(
                    ['{urun_adi}', '{parca_numarasi}', '{kategori}', '{stok_durumu}', '{site_adi}', '{urun_url}'],
                    [
                        $part->name, 
                        $part->part_number, 
                        $part->category ? $part->category->name : 'Belirtilmemiş', 
                        'Stok tükenmiştir',
                        $siteName,
                        config('app.url', 'http://localhost') . "/admin/parts/{$part->id}/edit"
                    ],
                    $template->body
                );
                
                $subject = str_replace('{urun_adi}', $part->name, $template->subject);
                
                Mail::send([], [], function ($message) use ($notificationEmail, $subject, $emailContent) {
                    $message->to($notificationEmail)
                        ->subject($subject)
                        ->html($emailContent);
                });
            } else {
                // Fall back to built-in template
                Mail::send([], [], function ($message) use ($part, $notificationEmail, $siteName) {
                    $message->to($notificationEmail)
                        ->subject("[$siteName] Stok Tükendi: {$part->name}")
                        ->html(self::buildStockNotificationEmail($part, 'depleted'));
                });
            }
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send stock depleted notification: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Send a notification when stock is low for a part
     *
     * @param Part $part The part that has low stock
     * @return bool Whether the notification was sent successfully
     */
    public static function sendLowStockNotification(Part $part)
    {
        $notificationEmail = config('site.notification_email');
        
        // If no notification email is set, don't send anything
        if (empty($notificationEmail)) {
            Log::info('No notification email set for stock alerts');
            return false;
        }
        
        try {
            $siteName = config('app.name', 'Parca Magaza');
            
            // Check if we have a stock notification template
            $template = EmailTemplate::where('name', 'Stok Bildirimi')->where('is_active', true)->first();
            
            if ($template) {
                // Use the template with variables replaced
                $emailContent = str_replace(
                    ['{urun_adi}', '{parca_numarasi}', '{kategori}', '{stok_durumu}', '{site_adi}', '{urun_url}'],
                    [
                        $part->name, 
                        $part->part_number, 
                        $part->category ? $part->category->name : 'Belirtilmemiş', 
                        "Düşük stok: {$part->stock_quantity} adet kaldı",
                        $siteName,
                        config('app.url', 'http://localhost') . "/admin/parts/{$part->id}/edit"
                    ],
                    $template->body
                );
                
                $subject = str_replace('{urun_adi}', $part->name, $template->subject);
                
                Mail::send([], [], function ($message) use ($notificationEmail, $subject, $emailContent) {
                    $message->to($notificationEmail)
                        ->subject($subject)
                        ->html($emailContent);
                });
            } else {
                // Fall back to built-in template
                Mail::send([], [], function ($message) use ($part, $notificationEmail, $siteName) {
                    $message->to($notificationEmail)
                        ->subject("[$siteName] Düşük Stok Uyarısı: {$part->name}")
                        ->html(self::buildStockNotificationEmail($part, 'low'));
                });
            }
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send low stock notification: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Build the HTML email content for stock notifications
     *
     * @param Part $part The part with stock issue
     * @param string $type The type of notification ('depleted' or 'low')
     * @return string The HTML email content
     */
    private static function buildStockNotificationEmail(Part $part, string $type): string
    {
        $siteName = config('app.name', 'Parca Magaza');
        $siteUrl = config('app.url', 'http://localhost');
        $adminPartUrl = "$siteUrl/admin/parts/{$part->id}/edit";
        
        $title = $type === 'depleted' ? 'Stok Tükendi' : 'Düşük Stok Uyarısı';
        $color = $type === 'depleted' ? '#dc3545' : '#ffc107';
        $icon = $type === 'depleted' ? '⚠️' : '⚠️';
        $stockText = $type === 'depleted' ? 'Stok tükenmiştir' : "Kalan stok: {$part->stock_quantity}";
        
        return '
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; color: #333;">
                <div style="background-color: ' . $color . '; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0;">
                    <h1 style="margin: 0; font-size: 24px;">' . $icon . ' ' . $title . '</h1>
                </div>
                
                <div style="background-color: #f8f9fa; padding: 20px; border-left: 1px solid #ddd; border-right: 1px solid #ddd;">
                    <h2 style="color: #1e3a8a; margin-top: 0;">Parça: ' . $part->name . '</h2>
                    
                    <div style="background-color: #e6f7ff; border-left: 4px solid #1e88e5; padding: 15px; margin: 20px 0;">
                        <p style="margin: 0; font-size: 16px;">
                            <strong>Parça Bilgileri:</strong><br>
                            Parça Numarası: ' . $part->part_number . '<br>
                            Kategori: ' . ($part->category ? $part->category->name : 'Belirtilmemiş') . '<br>
                            ' . $stockText . '
                        </p>
                    </div>
                    
                    <p style="font-size: 16px; line-height: 1.5;">
                        Bu ürün için stok güncellenmesi gerekiyor. Aşağıdaki düğmeyi kullanarak ürün stok ayarlarını güncelleyebilirsiniz.
                    </p>
                    
                    <div style="text-align: center; margin: 30px 0;">
                        <a href="' . $adminPartUrl . '" style="background-color: #1e3a8a; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">Ürün Stok Ayarlarını Güncelle</a>
                    </div>
                </div>
                
                <div style="background-color: #f1f1f1; padding: 15px; font-size: 12px; text-align: center; color: #666; border-radius: 0 0 5px 5px; border: 1px solid #ddd; border-top: none;">
                    <p>Bu e-posta, ' . $siteName . ' tarafından otomatik olarak gönderilmiştir.</p>
                </div>
            </div>';
    }
} 