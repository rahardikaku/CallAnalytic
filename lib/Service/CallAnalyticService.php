<?php

namespace OCA\CallAnalytic\Service;

use OCP\IDBConnection;
use OCP\IUserSession;
use OCP\DB\QueryBuilder\IQueryBuilder;

class CallAnalyticService {
	/** @var IDBConnection */
    protected $dbConn;

	public function __construct (
		IDBConnection $dbConn,
	) {
		$this->dbConn = $dbConn;
    }

	/**
     *ANR ARMS INIT DATA
     */
    public function initTimeSeriesData($user){
		$qb = $this->dbConn->getQueryBuilder();
		$result = $qb->select('*')
				->from('call_count')
				->where(
				$qb->expr()->eq('actor_id', $qb->createNamedParameter($user->getUID()))
				)
				->andWhere(
				$qb->expr()->eq('is_total', $qb->createNamedParameter(false,IQueryBuilder::PARAM_BOOL))
				)
				->setMaxResults(10)
				->orderBy('id', 'ASC')
				->execute();

		$data = $result->fetchAll(); 
		$tmp = $data[0]['tanggal'];
		//throw new \Exception( "\$data = $tmp" ); 
		return $data;
    }

    public function initiateTotalCountChat($user){
		$qb = $this->dbConn->getQueryBuilder();
		$result = $qb->select('*')
				->from('call_count')
				->where(
				$qb->expr()->eq('actor_id', $qb->createNamedParameter($user->getUID()))
				)
				->andWhere(
				$qb->expr()->eq('is_total', $qb->createNamedParameter(true))
				)
				->execute();

		$data = $result->fetch(); 
		return $data;
    }

	//ANR ARMS
	//LOG COUNT FOR KKP
	public function checkCountRecordExist($actorId,$currentDate){
		$checkResult = array();
		$qb = $this->dbConn->getQueryBuilder();
		$result = $qb->select('*')
		    ->from('call_count')
		    ->where(
		       $qb->expr()->eq('actor_id', $qb->createNamedParameter($actorId))
		    )
		    ->andWhere(
			$qb->expr()->eq('tanggal', $qb->createNamedParameter($currentDate))
		    )
		    ->execute();

		$data = $result->fetch();
		$result->closeCursor();
		$null = !$data;
		array_push($checkResult,$data);
		array_push($checkResult,$null);
		//throw new \Exception( "\$null = $null" );
		return $checkResult;
	}

	public function createCountRecord($actorId,$currentDate,$messageType){
		$qb = $this->dbConn->getQueryBuilder();
		$values = [
		   'actor_id' => $qb->createNamedParameter($actorId),
		   'tanggal' => $qb->createNamedParameter($currentDate),		   
		   'count_total'=> $qb->createNamedParameter(1)
		];
		if ($messageType === 'call_started') {
		   $values['count_out'] = $qb->createNamedParameter(1);
		}else{
		   $values['count_in'] = $qb->createNamedParameter(1);
		}
		$affectedRows = $qb->insert('call_count')
		     ->values($values)
	     	     ->execute();
	}

	public function createTotalRecord($actorId,$messageType){
		$qb = $this->dbConn->getQueryBuilder();
 	   	$values = [
		   'actor_id' => $qb->createNamedParameter($actorId),
		   'tanggal' => $qb->createNamedParameter(null),
		   'count_total'=> $qb->createNamedParameter(1),
		   'is_total' => $qb->createNamedParameter(true)
		];
		if ($messageType === 'call_started') {
		   $values['count_out'] = $qb->createNamedParameter(1);
		}else{
		   $values['count_in'] = $qb->createNamedParameter(1);
		}
		$affectedRows = $qb->insert('call_count')
		     ->values($values)
	     	     ->execute();

	}

	public function updateCountRecord($row,$actorId,$currentDate,$messageType){
		//$tmp = $row['count_out'];
		//throw new \Exception( "\$update = $tmp" );
		$qb = $this->dbConn->getQueryBuilder();
		if ($messageType === 'call_started'){
			//update count_out
			$affectedRows = $qb->update('call_count')
			   ->set('count_out',$qb->createNamedParameter($row['count_out']+1))
			   ->set('count_total',$qb->createNamedParameter($row['count_total']+1))
			   ->where(
			       $qb->expr()->eq('actor_id', $qb->createNamedParameter($actorId))
			    )
			    ->andWhere(
				$qb->expr()->eq('tanggal', $qb->createNamedParameter($currentDate))
			    )
			   ->execute();

		}else{
			//update count in
			$affectedRows = $qb->update('call_count')
			   ->set('count_in',$qb->createNamedParameter($row['count_in']+1))
			   ->set('count_total',$qb->createNamedParameter($row['count_total']+1))
			   ->where(
			       $qb->expr()->eq('actor_id', $qb->createNamedParameter($actorId))
			    )
			    ->andWhere(
				$qb->expr()->eq('tanggal', $qb->createNamedParameter($currentDate))
			    )
			   ->execute();

		}
		
	}

	public function updateTotalRecord($actorId,$messageType){
		$qb = $this->dbConn->getQueryBuilder();
		$result = $qb->select('*')
		    ->from('call_count')
		    ->where(
		       $qb->expr()->eq('actor_id', $qb->createNamedParameter($actorId))
		    )
		    ->andWhere(
			$qb->expr()->eq('is_total', $qb->createNamedParameter(true))
		    )
		    ->execute();

		$data = $result->fetch();
		$result->closeCursor();
		//throw new \Exception( "\$data = $data" );

		if ($data){
		   if ($messageType === 'call_started'){
			$affectedRows = $qb->update('call_count')
			   ->set('count_out',$qb->createNamedParameter($data['count_out']+1))
			   ->set('count_total',$qb->createNamedParameter($data['count_total']+1))
			   ->where(
			       $qb->expr()->eq('actor_id', $qb->createNamedParameter($actorId))
			    )
			    ->andWhere(
			       $qb->expr()->eq('is_total',$qb->createNamedParameter(true))
			    )
			   ->execute();

		  }else{
			//update count in
			$affectedRows = $qb->update('call_count')
			   ->set('count_in',$qb->createNamedParameter($data['count_in']+1))
			   ->set('count_total',$qb->createNamedParameter($data['count_total']+1))
			   ->where(
			       $qb->expr()->eq('actor_id', $qb->createNamedParameter($actorId))
			    )
			    ->andWhere(
				$qb->expr()->eq('is_total', $qb->createNamedParameter(true))
			    )
			   ->execute();

		 }
		}

	}

} 