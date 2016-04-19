define(function(require, exports, module) {

    var Notify = require('common/bootstrap-notify');

    exports.run = function() {

        var $list = $("#course-student-list");

        $list.on('click', '.student-remove', function(){
            var $tr = $(this).parents('tr');
            var user_name = $('.student-remove').data('user') ;
            if (!confirm(Translator.trans('您真的要移除该%username%吗？',{username:user_name}))) {
                return ;
            }

            $.post($(this).data('url'), function(){
            	var user_name = $('.student-remove').data('user') ;
                Notify.success(Translator.trans('移除%username%成功！',{username:user_name}));
                $tr.remove();
            }).error(function(){
            	var user_name = $('.student-remove').data('user') ;
                Notify.danger(Translator.trans('移除%username%失败，请重试！',{username:user_name}));
            });
        });



        $("#course-student-list").on('click', '.follow-student-btn, .unfollow-student-btn', function() {
            
            var $this = $(this);

            $.post($this.data('url'), function(){
                $this.hide();
                if ($this.hasClass('follow-student-btn')) {
                    $this.parent().find('.unfollow-student-btn').show();
                } else {
                    $this.parent().find('.follow-student-btn').show();
                }
            });
            
        });

    }

});