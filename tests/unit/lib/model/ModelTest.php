<?php

namespace meteocontrol\client\vcomapi;

use meteocontrol\vcomapi\model\Outage;
use meteocontrol\vcomapi\model\AttachmentFile;
use meteocontrol\vcomapi\model\Comment;
use meteocontrol\vcomapi\model\CommentDetail;
use meteocontrol\vcomapi\model\Coordinates;
use meteocontrol\vcomapi\model\MeasurementValue;
use meteocontrol\vcomapi\model\MeasurementValueWithInterval;
use meteocontrol\vcomapi\model\SystemDetail;
use meteocontrol\vcomapi\model\Ticket;
use meteocontrol\vcomapi\model\TicketHistory;
use PHPUnit\Framework\TestCase;

class ModelTest extends TestCase {

    public function testModelEncodeToJson() {
        $dateTime = new \DateTime('2018-01-02T03:04:01+00:00');
        $intValue = 1;
        $floatValue = 0.1;
        $stringValue = 'string';
        $booleanValue = true;
        $intervalValue = 300;
        $expectedData = json_decode(file_get_contents(__DIR__ . '/_files/models.json'), true);

        $attachmentFile = new AttachmentFile();
        $attachmentFile->attachmentId = $attachmentFile->creatorId = $intValue;
        $attachmentFile->filename = $attachmentFile->content = $attachmentFile->description = $stringValue;
        $attachmentFile->createdAt = $dateTime;

        $comment = new Comment();
        $comment->commentId = $intValue;
        $comment->comment = $comment->username = $comment->firstName =
        $comment->lastName = $stringValue;
        $comment->createdAt = $dateTime;

        $commentDetail = new CommentDetail();
        $commentDetail->commentId = $intValue;
        $commentDetail->comment = $commentDetail->username = $commentDetail->firstName =
        $commentDetail->lastName = $stringValue;
        $commentDetail->createdAt = $dateTime;

        $measurementValue = new MeasurementValue();
        $measurementValue->value = $stringValue;
        $measurementValue->timestamp = $dateTime;

        $measurementValueWithInterval = new MeasurementValueWithInterval();
        $measurementValueWithInterval->value = $stringValue;
        $measurementValueWithInterval->timestamp = $dateTime;
        $measurementValueWithInterval->interval = $intervalValue;

        $ticket = new Ticket();
        $ticket->id = (string)$intValue;
        $ticket->causeId = $intValue;
        $ticket->systemKey = $ticket->designation = $ticket->summary = $ticket->assignee =
        $ticket->status = $ticket->priority = $ticket->includeInReports = $ticket->severity =
        $ticket->description = $stringValue;
        $ticket->fieldService = $booleanValue;
        $ticket->createdAt = $ticket->lastChangedAt = $ticket->rectifiedAt = $dateTime;
        $ticket->outage = new Outage();
        $ticket->outage->startedAt = $ticket->outage->endedAt = $dateTime;
        $ticket->outage->shouldInfluenceAvailability = $ticket->outage->shouldInfluencePr = $booleanValue;
        $ticket->outage->affectedPower = $floatValue;

        $ticketHistory = new TicketHistory();
        $ticketHistory->action = $ticketHistory->personInCharge = $ticketHistory->from =
        $ticketHistory->to = $stringValue;
        $ticketHistory->createdAt = $dateTime;

        $systemDetail = new SystemDetail();
        $systemDetail->elevation = $intValue;
        $systemDetail->name = $systemDetail->currency = $stringValue;
        $systemDetail->commissionDate = $dateTime;
        $systemDetail->hasSolarForecast = $booleanValue;

        $coordinates = new Coordinates();
        $coordinates->latitude = $coordinates->longitude = $floatValue;

        $this->assertEquals($expectedData['attachmentFile'], json_decode(json_encode($attachmentFile), true));
        $this->assertEquals($expectedData['comment'], json_decode(json_encode($comment), true));
        $this->assertEquals($expectedData['commentDetail'], json_decode(json_encode($commentDetail), true));
        $this->assertEquals($expectedData['measurementValue'], json_decode(json_encode($measurementValue), true));
        $this->assertEquals(
            $expectedData['measurementValueWithInterval'],
            json_decode(json_encode($measurementValueWithInterval), true)
        );
        $this->assertEquals($expectedData['ticket'], json_decode(json_encode($ticket), true));
        $this->assertEquals($expectedData['ticketHistory'], json_decode(json_encode($ticketHistory), true));
        $this->assertEquals($expectedData['systemDetail'], json_decode(json_encode($systemDetail), true));
        $this->assertEquals($expectedData['coordinates'], json_decode(json_encode($coordinates), true));
    }

    public function testDecodeJsonToSystemDetail() {
        $expectedTimestamp = '2018-01-01';
        $expectedTimezones = [
            new \DateTimeZone('Europe/Berlin'),
            new \DateTimeZone('Asia/Kolkata'),
            (new \DateTime())->getTimezone()
        ];

        $testData = json_decode(file_get_contents(__DIR__ . '/_files/systemDetails.json'), true);
        $systemDetails = SystemDetail::deserializeArray($testData);

        /** @var SystemDetail $systemDetail */
        foreach ($systemDetails as $index => $systemDetail) {
            $this->assertEquals($expectedTimestamp, $systemDetail->commissionDate->format('Y-m-d'));
            $this->assertEquals($expectedTimezones[$index], $systemDetail->commissionDate->getTimezone());
        }
    }
}
