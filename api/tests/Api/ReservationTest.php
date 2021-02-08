<?php

namespace App\Tests\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Reservation;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;

class ReservationTest extends ApiTestCase 
{    
    public function testCreateReservation(): void
    {
        $token = $this->getToken();

        $response = static::createClient()->request('POST', '/reservations', 
            [
                'json' => [
                    'position' => '/positions/1',
                    'date' => '2021-02-07',
                    'timeStart' => '2021-02-07 10:00',
                    'timeEnd' => '2021-02-07 11:30'
                ],
                'headers' => [
                    'Authorization' => 'Bearer '. $token
                ],
            ],
        );
        
        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        
        $this->assertJsonContains([
            '@context' => '/contexts/Reservation',
            '@type' => 'Reservation',
            'date' => '2021-02-07T00:00:00+00:00',
            'timeStart' => '2021-02-07T10:00:00+00:00',
            'timeEnd' => '2021-02-07T11:30:00+00:00',
        ]);
        $this->assertMatchesRegularExpression('~^/reservations/\d+$~', $response->toArray()['@id']);
        $this->assertMatchesResourceItemJsonSchema(Reservation::class);
    }
    
    public function testCreateInvalidReservationWhenStartTimeLaterThanEndTime(): void
    {
        $token = $this->getToken();
                
        $response = static::createClient()->request('POST', '/reservations', [
            'json' => [
                'position' => '/positions/2',
                'date' => '2021-02-07',
                'timeStart' => '12:00',
                'timeEnd' => '11:30'
            ],
            'headers' => [
                'Authorization' => 'Bearer '. $token
            ],
        ]);
        
        $this->assertResponseStatusCodeSame(422);
        
        $this->assertJsonContains([
            '@context' => '/contexts/ConstraintViolationList',
            '@type' => 'ConstraintViolationList',
            'hydra:title' => 'An error occurred',
            'hydra:description' => 'Start time can\'t be later than end time'
        ]);
    }
        
    public function testCreateInvalidReservationWhenStartTimeOrEndTimeNotFullOrHalfHour(): void
    {
        $token = $this->getToken();
                
        $response = static::createClient()->request('POST', '/reservations', [
            'json' => [
                'position' => '/positions/3',
                'date' => '2021-02-07',
                'timeStart' => '10:01',
                'timeEnd' => '11:45'
            ],
            'headers' => [
                'Authorization' => 'Bearer '. $token
            ],
        ]);
        
        $this->assertResponseStatusCodeSame(422);
        
        $this->assertJsonContains([
            '@context' => '/contexts/ConstraintViolationList',
            '@type' => 'ConstraintViolationList',
            'hydra:title' => 'An error occurred',
            'hydra:description' => 'time_start: Hour has to be full or half past - it means end :00 or :30
time_end: Hour has to be full or half past - it means end :00 or :30'
        ]);
    }
    
    public function testCreateInvalidReservationWhenStartTimeOrEndTimeEarlierThanStartTime(): void
    {
        $token = $this->getToken();
                
        $response = static::createClient()->request('POST', '/reservations', [
            'json' => [
                'position' => '/positions/2',
                'date' => '2021-02-07',
                'timeStart' => '07:00',
                'timeEnd' => '20:30'
            ],
            'headers' => [
                'Authorization' => 'Bearer '. $token
            ],
        ]);
        
        $this->assertResponseStatusCodeSame(422);
        
        $this->assertJsonContains([
            '@context' => '/contexts/ConstraintViolationList',
            '@type' => 'ConstraintViolationList',
            'hydra:title' => 'An error occurred',
            'hydra:description' => 'Start time can\'t be earlier than open time and later than close time
End time can\'t be earlier than open time and later than close time'
        ]);
    }
    
    private function getToken(): string
    {
        $response = static::createClient()->request('POST', '/authentication_token', ['json' => [
            'email' => 'user1@example.com',
            'password' => 'haslo111',
        ]]);
        
        $this->assertResponseIsSuccessful();
        
        return json_decode($response->getContent())->token;
    }
}
