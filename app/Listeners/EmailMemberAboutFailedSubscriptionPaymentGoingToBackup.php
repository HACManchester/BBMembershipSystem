<?php

namespace BB\Listeners;

use BB\Events\SubscriptionPayment;
use BB\Repo\UserRepository;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailMemberAboutFailedSubscriptionPaymentGoingToBackup implements ShouldQueue
{
    /**
     * @var Mailer
     */
    private $mailer;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * Create the event listener.
     *
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer, UserRepository $userRepository)
    {
        $this->mailer = $mailer;
        $this->userRepository = $userRepository;
    }

    /**
     * Handle the event.
     *
     * @param SubscriptionPayment\InsufficientFundsTryingDirectDebit $event
     */
    public function handle(SubscriptionPayment\InsufficientFundsTryingDirectDebit $event)
    {
        $user = $this->userRepository->getById($event->userId);
        $this->mailer->send('emails.sub-payment-failed-trying-dd', ['user' => $user], function ($m) use ($user) {
            $m->to($user->email, $user->name)->subject('Your subscription payment failed');
        });
    }
}
