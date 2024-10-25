<?php
// tests/Service/MailServiceTest.php
namespace App\Tests\Service;

use App\Service\MailService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mime\Email;

class MailServiceTest extends KernelTestCase
{
    public function testSendEmail()
    {
        $mailer = $this->createMock(MailerInterface::class);
        $mailer->expects($this->once())
            ->method('send')
            ->with($this->callback(function(Email $email) {
                return $email->getFrom() === ['you@example.com'] &&
                       $email->getTo() === ['recipient@example.com'] &&
                       $email->getSubject() === 'Test Subject' &&
                       $email->getTextBody() === 'This is a test email.';
            }));

        $mailService = new MailService($mailer);
        $mailService->sendEmail('recipient@example.com', 'Test Subject', 'This is a test email.');
    }
}
