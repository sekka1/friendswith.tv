<?php 
class FriendsController extends AppController {
	public $name = 'Friends';
	public $uses = array('Friend','User');
	function index() {
		$fbFriends = FB::api('me/friends');
		$friend_ids = Set::extract('data.{n}.id',$fbFriends);
		$friendsWithTv = $this->User->find('all',array('conditions'=>array('facebook_id'=>$friend_ids)));
		$friendsWithTvIds = Set::extract('/User/id',$friendsWithTv);
		$friendsWithTvFacebookIds = Set::extract('/User/facebook_id',$friendsWithTv);
		$friends = array();
		foreach($fbFriends['data'] as $k => $friend){
			$friends[$k]=$friend;
			$friends[$k]['facebook_id']=$friend['id'];
			if(in_array($friends[$k]['facebook_id'],$friendsWithTvFacebookIds)){
				$j = array_search($friends[$k]['facebook_id'],$friendsWithTvFacebookIds);
				$friends[$k]['id'] = $friendsWithTvIds[$j];
				$friends[$k]['has_fwt']=true;
			}else{
				$friends[$k]['id']=null;
				$friends[$k]['has_fwt']=false;
			}
		}
		$this->set(compact('friends'));
	}
	
	function _has_fwt(){
	
	}
}
