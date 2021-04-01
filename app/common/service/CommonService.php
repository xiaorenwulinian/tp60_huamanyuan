<?php

namespace app\common\service;


use think\facade\Db;

/**
 *
 * Class CommonService
 * @package app\common\service
 */
class CommonService
{
    /**
     * 影响因素
     * @param $params
     * @param $facilityId
     * @param $content
     * @return bool
     */
    public function environmentFactor($params, $facilityId, $content, $type = 1)
    {
        $curDate = date('Y-m-d H:i:s');
        if (!empty($content)) {
            $data = Db::name('environment_factor')
                ->where('id_deleted',2)
                ->where('facility_id', $facilityId)
                ->where('type', $type)
                ->column('*','id');

            $hasIdArr = array_keys($data);
            $insert = [];
            $reqIdArr = [];

            foreach ($content as $v) {
                if (empty($v['name'])
                    || empty($v['project'])
                ) {
                    continue;
                }

                if ($v['id'] == 0) {
                    $temp = [
                        'name'          => $v['name'],
                        'project'       => $v['project'],
                        'company_id'    => $params['company_id'],
                        'facility_id'   => $facilityId,
                        'type'          => $type,
                        'related_activity' => $v['related_activity'] ?? '',
                        'related_product'  => $v['related_product'] ?? '',
                        'create_time'   => $curDate,
                        'update_time'   => $curDate,
                    ];
                    array_push($insert, $temp);
                } else {
                    if (!in_array($v['id'], $hasIdArr)) {
                        continue;
                    }

                    $reqIdArr[] = $v['id'];
                    $curData = $data[$v['id']];

                    if ($curData['name'] == $v['name']
                        && $curData['project'] == $v['project']
                    ) {
                        continue;
                    }

                    Db::name('environment_factor')
                        ->where('id',$v['id'])
                        ->where('type', $type)
                        ->update([
                            'name'          => $v['name'],
                            'project'       => $v['project'],
                            'related_activity' => $v['related_activity'] ?? '',
                            'related_product'  => $v['related_product'] ?? '',
                            'update_time'      => $curDate,
                        ]);
                }

            }

            $deleteIdArr = array_diff($hasIdArr, $reqIdArr);

            if (!empty($deleteIdArr)) {
                Db::name('environment_factor')
                    ->where('id','in', $deleteIdArr)
                    ->where('type', $type)
                    ->where('facility_id',$facilityId)
                    ->update([
                        'is_deleted' => 1,
                        'update_time'=> $curDate,
                    ]);
            }

            if (!empty($insert)) {
                Db::name('environment_factor')->insertAll($insert);
            }

        } else {
            Db::name('environment_factor')
                ->where('type', $type)
                ->where('facility_id',$facilityId)
                ->update([
                    'is_deleted' => 1,
                    'update_time'=> $curDate,
                ]);

        }

        return true;

    }
}