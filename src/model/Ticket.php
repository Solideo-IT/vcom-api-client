<?php

namespace meteocontrol\client\vcomapi\model;

class Ticket extends BaseModel {

    const REPORT_TYPE_NO = 'no';
    const REPORT_TYPE_DETAIL = 'detail';
    const REPORT_TYPE_SUMMARY = 'summary';

    const STATUS_OPEN = 'open';
    const STATUS_CLOSED = 'closed';
    const STATUS_DELETED = 'deleted';
    const STATUS_ASSIGNED = 'assigned';
    const STATUS_INPROGRESS = 'inProgress';

    const SEVERITY_NORMAL = 'normal';
    const SEVERITY_HIGH = 'high';
    const SEVERITY_CRITICAL = 'critical';

    const PRIORITY_LOW = 'low';
    const PRIORITY_NORMAL = 'normal';
    const PRIORITY_HIGH = 'high';
    const PRIORITY_URGENT = 'urgent';

    /** @var int */
    public $id;

    /** @var string */
    public $systemKey;

    /** @var string */
    public $designation;

    /** @var string */
    public $summary;

    /** @var \DateTime */
    public $date;

    /** @var \DateTime */
    public $lastChange;

    /** @var \DateTime */
    public $rectifiedOn;

    /** @var string */
    public $assignee;

    /** @var string */
    public $status;

    /** @var int */
    public $causeId;

    /** @var string */
    public $priority;

    /** @var string */
    public $includeInReports;

    /** @var bool */
    public $fieldService;

    /** @var string */
    public $severity;

    /** @var string */
    public $description;

    /**
     * @return bool
     */
    public function isValid() {
        return !empty($this->systemKey) && !empty($this->designation) && !empty($this->date);
    }
}
