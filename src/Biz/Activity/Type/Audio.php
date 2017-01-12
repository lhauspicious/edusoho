<?php

namespace Biz\Activity\Type;

use Biz\Activity\Config\Activity;

class Audio extends Activity
{
    /**
     * @inheritdoc
     */
    public function create($fields)
    {
        if (empty($fields['ext'])) {
            throw $this->createInvalidArgumentException('参数不正确');
        }
        $audioActivity = $this->getAudioActivityDao()->create($fields['ext']);
        return $audioActivity;
    }

    /**
     * @inheritdoc
     */
    public function update($targetId, &$fields, $activity)
    {
        $audioActivityFields = $fields['ext'];

        $audioActivity = $this->getAudioActivityDao()->get($fields['mediaId']);
        if (empty($audioActivity)) {
            throw $this->createNotFoundException('教学活动不存在');
        }
        $audioActivity = $this->getAudioActivityDao()->update($fields['mediaId'], $audioActivityFields);
        return $audioActivity;
    }

    /**
     * TODO观看后完成
     */
    public function isFinished($activityId)
    {
        $result   = $this->getActivityLearnLogService()->sumLearnedTimeByActivityId($activityId);
        $activity = $this->getActivityService()->getActivity($activityId);
        return !empty($result)
        && $result > $activity['length'];
    }

    /**
     * @inheritdoc
     */
    public function delete($id)
    {
        $this->getAudioActivityDao()->delete($id);
    }

    /**
     * @inheritdoc
     */
    public function get($id)
    {
        $audioActivity         = $this->getAudioActivityDao()->get($id);
        $audioActivity['file'] = $this->getUploadFileService()->getFullFile($audioActivity['mediaId']);
        return $audioActivity;
    }

    protected function registerListeners()
    {
        return array();
    }

    protected function getAudioActivityDao()
    {
        return $this->getBiz()->dao("Activity:AudioActivityDao");
    }

    protected function getActivityLearnLogService()
    {
        return $this->getBiz()->service("Activity:ActivityLearnLogService");
    }

    protected function getActivityService()
    {
        return $this->getBiz()->service("Activity:ActivityService");
    }

    protected function getUploadFileService()
    {
        return $this->getBiz()->service('File:UploadFileService');
    }
}