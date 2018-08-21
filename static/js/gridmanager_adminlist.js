/*
* @Author: zuoliguang
* @Date:   2018-08-21 10:09:08
* @Last Modified by:   zuoliguang
* @Last Modified time: 2018-08-21 14:48:15
*/

// GridManager 渲染
var table = document.querySelector('table');
function init() {
	table.GM({
		gridManagerName: '管理员列表',
        width: '100%',
		height: '100%',
		supportAjaxPage:true,
		isCombSorting: true,
		ajax_data: function () {
			return dataUrl;
		},

		// 请求方式
		ajax_type: 'POST',

		// 请求参数
		query: {},

		// 选择事件执行前事件
		checkedBefore: function(checkedList){
			console.log('checkedBefore==', checkedList);
		},

		// 选择事件执行后事件
		checkedAfter: function(checkedList){
			console.log('checkedAfter==', checkedList);
		},

		// 全选事件执行前事件
		checkedAllBefore: function(checkedList){
			console.log('checkedAllBefore==', checkedList);
		},

		// 全选事件执行后事件
		checkedAllAfter: function(checkedList){
			console.log('checkedAllAfter==', checkedList);
		},

		// AJAX请求前事件函数
		ajax_beforeSend: function(promise){
			console.log('ajax_beforeSend');
		},
		// AJAX成功事件函数
		ajax_success: function(response){
			console.log('ajax_success');
		},

		// AJAX失败事件函数
		ajax_error: function(error){
			console.log('ajax_error');
		},

		// AJAX结束事件函数
		ajax_complete: function(complete){
			console.log('ajax_complete');
		},

		dataKey: 'list',

		// 通过该方法修改全部的请求参数
		requestHandler: function(request){
			// request.newParams = '这个参数是通过 requestHandler 函数新增的';
			return request;
		},

		// 可以通过该方法修改返回的数据
		responseHandler: function(response){
			// 数据本身返回为data, 通过responseHandler更改为与dataKey匹配的值
			response.list = response.data;
			return response;
		},

		columnData: [
			{
				key: 'icon',
				remind: 'icon',
				align: 'center',
				text: '头像',
				// 使用函数返回 rowObject[数据行信息]
				template: function(pic, rowObject) {
					var imgNode = document.createElement('img');
					imgNode.style.width = '30px';
					imgNode.style.margin = '0 auto';
					imgNode.alt = rowObject.username;
					imgNode.src = `${pic}`;
					return imgNode;
				}
			},{
				key: 'username',
				remind: 'username',
				align: 'left',
				text: '管理员',
				align: 'center',
				template: function(username, rowObject) {
					var titleNode = document.createElement('a');
					titleNode.setAttribute('href', `${rowObject.web}`);
					titleNode.setAttribute('title', username);
					titleNode.setAttribute('target', '_blank');
					titleNode.innerText = username;
					titleNode.title = `个人主页[${rowObject.web}]`;
					titleNode.classList.add('plugin-action');
					return titleNode;
				}
			},{
				key: 'telphone',
				remind: 'telphone',
				text: '联系方式',
				align: 'center'
			},{
				key: 'sex',
				remind: 'sex',
				text: '性别',
				align: 'center'
			},{
				key: 'email',
				remind: 'email',
				text: '邮箱',
				align: 'center'
			},{
				key: 'type',
				remind: 'type',
				text: '类型',
				align: 'center'
			},{
				key: 'right',
				remind: 'right',
				text: '权限',
				align: 'center'
			},{
				key: 'last_login_time',
				remind: 'lastDatetime',
				text: '最近登录',
				align: 'center'
			},{
				key: 'action',
				remind: 'action',
				align: 'center',
				text: '<span style="color: red">操作</span>',
				// 直接返回 htmlString
				template: '<span class="plugin-action" gm-click="delectRowData">删除</span>'
			}
		],
		
		// 排序后事件
		sortingAfter: function (data) {
			console.log('sortAfter', data);
		}
	}, function(query){
		// 渲染完成后的回调函数
		console.log('渲染完成后的回调函数:', query);
	});
}

/**
 * 删除操作
 * @author zuoliguang 2018-08-21
 * @param  {[type]} rowData [description]
 * @return {[type]}         [description]
 */
function delectRowData(rowData){
	// 执行删除操作
	if(window.confirm('确认要删除['+rowData.id+']?')){
		window.alert('该操作暂时不提供，联系开发人员');
	}
}

 /**
  * 搜索, 重置
  * @author zuoliguang 2018-08-21
  * @return {[type]} [description]
  */
(function(){
	// 搜索
	document.querySelector('.search-action').addEventListener('click', function () {
		var _query = {
			username: document.querySelector('[name="username"]').value,
			telphone: document.querySelector('[name="telphone"]').value,
			email: document.querySelector('[name="email"]').value,
			cPage: 1
		};
		table.GM('setQuery', _query, function(){
			console.log('setQuery执行成功');
		});
	});

	// 重置
	document.querySelector('.reset-action').addEventListener('click', function () {
		document.querySelector('[name="username"]').value = '';
		document.querySelector('[name="telphone"]').value = '';
		document.querySelector('[name="email"]').value = '';
	});
})();


/**
 * 绑定 实例化, 消毁事件
 * @author zuoliguang 2018-08-21
 * @return {[type]} [description]
 */
(function () {
	var initDOM = document.getElementById('init-gm');
	var destroyDOM = document.getElementById('destroy-gm');
	var codeShowDOM = document.querySelector('.code-show');
	// 绑定初始化事件
	initDOM.onclick = function(){
		init();
		initDOM.setAttribute('disabled', '');
		destroyDOM.removeAttribute('disabled');
	};
	// 绑定消毁事件
	destroyDOM.onclick = function(){
		table.GM('destroy');
		initDOM.removeAttribute('disabled');
		destroyDOM.setAttribute('disabled', '');
	};
})();

/**
 * 初始进入时, 执行init 方法
 * @author zuoliguang 2018-08-21
 * @return {[type]} [description]
 */
(function(){
	init();
	var initDOM = document.getElementById('init-gm');
	var destroyDOM = document.getElementById('destroy-gm');
	initDOM.setAttribute('disabled', '');
	destroyDOM.removeAttribute('disabled');
})();