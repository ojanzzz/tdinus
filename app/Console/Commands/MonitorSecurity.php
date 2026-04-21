<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class MonitorSecurity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'security:monitor {--report : Generate security report}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monitor security events and generate reports';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('report')) {
            $this->generateSecurityReport();
        } else {
            $this->monitorActiveThreats();
        }
    }

    /**
     * Monitor active security threats.
     */
    protected function monitorActiveThreats(): void
    {
        $this->info('🔍 Monitoring active security threats...');

        // Check for suspicious login attempts
        $suspiciousLogins = $this->getSuspiciousLoginAttempts();
        if (!empty($suspiciousLogins)) {
            $this->warn('⚠️  Suspicious login attempts detected:');
            foreach ($suspiciousLogins as $login) {
                $this->line("  - IP: {$login['ip']}, Attempts: {$login['attempts']}, Last: {$login['last_attempt']}");
            }
        }

        // Check for rate limiting violations
        $rateLimitViolations = $this->getRateLimitViolations();
        if ($rateLimitViolations > 0) {
            $this->warn("⚠️  Rate limit violations in last hour: {$rateLimitViolations}");
        }

        // Check for failed authentications
        $failedAuths = $this->getFailedAuthentications();
        if ($failedAuths > 10) {
            $this->error("🚨 High number of failed authentications: {$failedAuths}");
        }

        $this->info('✅ Security monitoring completed');
    }

    /**
     * Generate comprehensive security report.
     */
    protected function generateSecurityReport(): void
    {
        $this->info('📊 Generating security report...');

        $report = [
            'generated_at' => now()->toDateTimeString(),
            'period' => 'Last 24 hours',
            'metrics' => [
                'total_logins' => $this->getTotalLogins(),
                'failed_logins' => $this->getFailedAuthentications(),
                'suspicious_ips' => count($this->getSuspiciousLoginAttempts()),
                'rate_limit_hits' => $this->getRateLimitViolations(),
                'blocked_uploads' => $this->getBlockedUploads(),
            ],
            'recommendations' => $this->generateRecommendations(),
        ];

        // Save report to file
        $filename = 'security_report_' . date('Y-m-d_H-i-s') . '.json';
        file_put_contents(storage_path('logs/' . $filename), json_encode($report, JSON_PRETTY_PRINT));

        $this->info("✅ Security report saved to: storage/logs/{$filename}");

        // Display summary
        $this->table(
            ['Metric', 'Value'],
            [
                ['Total Logins', $report['metrics']['total_logins']],
                ['Failed Logins', $report['metrics']['failed_logins']],
                ['Suspicious IPs', $report['metrics']['suspicious_ips']],
                ['Rate Limit Hits', $report['metrics']['rate_limit_hits']],
                ['Blocked Uploads', $report['metrics']['blocked_uploads']],
            ]
        );
    }

    /**
     * Get suspicious login attempts.
     */
    protected function getSuspiciousLoginAttempts(): array
    {
        // This would typically query from a security log table
        // For now, return mock data
        return Cache::get('suspicious_logins', []);
    }

    /**
     * Get rate limit violations.
     */
    protected function getRateLimitViolations(): int
    {
        // Query from logs or cache
        return Cache::get('rate_limit_violations', 0);
    }

    /**
     * Get failed authentications count.
     */
    protected function getFailedAuthentications(): int
    {
        // For now, return cached value or 0
        // In production, you might want to query from a dedicated security log table
        return Cache::get('failed_authentications_24h', 0);
    }

    /**
     * Get total logins.
     */
    protected function getTotalLogins(): int
    {
        return Cache::get('total_logins_24h', 0);
    }

    /**
     * Get blocked uploads count.
     */
    protected function getBlockedUploads(): int
    {
        return Cache::get('blocked_uploads', 0);
    }

    /**
     * Generate security recommendations.
     */
    protected function generateRecommendations(): array
    {
        $recommendations = [];

        if ($this->getFailedAuthentications() > 50) {
            $recommendations[] = 'High number of failed logins detected. Consider implementing stricter password policies.';
        }

        if (count($this->getSuspiciousLoginAttempts()) > 5) {
            $recommendations[] = 'Multiple suspicious IPs detected. Consider implementing IP blocking.';
        }

        if ($this->getRateLimitViolations() > 100) {
            $recommendations[] = 'High rate limit violations. Consider adjusting rate limits or investigating abuse.';
        }

        if (empty($recommendations)) {
            $recommendations[] = 'Security status is good. Continue monitoring regularly.';
        }

        return $recommendations;
    }
}