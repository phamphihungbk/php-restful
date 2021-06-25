<?php

namespace TinnyApi\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Config\Repository as ConfigRepository;

class VerifyEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var string
     */
    private $token;

    /**
     * @var ConfigRepository
     */
    private $configRepository;

    /**
     * VerifyEmailNotification constructor.
     *
     * @param ConfigRepository $configRepository
     */
    public function __construct(ConfigRepository $configRepository)
    {
        $this->configRepository = $configRepository;
        $this->onQueue('notifications');
    }

    public function via(): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())
            ->markdown('emails.default')
            ->success()
            ->subject(__(':app_name - Confirm your registration', ['app_name' => config('app.name')]))
            ->greeting(__('Welcome to :app_name', ['app_name' => config('app.name')]))
            ->line(__('Click the link below to complete verification:'))
            ->action(__('Verify Email'), url('/user/verify/' . $this->token))
            ->line('<b>' . __('5 Security Tips') . '</b>')
            ->line('<small>' . __('DO NOT give your password to anyone!') . '<br>' .
                __(
                    'DO NOT call any phone number for someone clainming to be :app_name support!',
                    ['app_name' => config('app.name')]
                ) . '<br>' .
                __(
                    'DO NOT send any money to anyone clainming to be a member of :app_name!',
                    ['app_name' => config('app.name')]
                ) . '<br>' .
                __('Enable Two Factor Authentication!') . '<br>' .
                __('Make sure you are visiting :app_url', [
                    'app_url' => $this->configRepository->get('app.url')
                ]) . '</small>');
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setToken(string $token): VerifyEmailNotification
    {
        $this->token = $token;

        return $this;
    }
}
