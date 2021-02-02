<link href="<{$xoops_url}>/modules/tadtools/css/font-awesome/css/font-awesome.css" rel="stylesheet">
<script>
function delete_tad_rss_func(rss_sn){
  var sure = window.confirm("<{$smarty.const._TAD_DEL_CONFIRM}>");
  if (!sure)  return;
  location.href="main.php?op=delete_tad_rss&rss_sn=" + rss_sn;
}
</script>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <form action="main.php" method="post" id="myForm" enctype="multipart/form-data" role="form">
        <{if $rss_sn}>
          <div class="form-group row">
            <div class="col-md-8">
              <input type="text" name="title" value="<{$title}>" class="form-control" placeholder="<{$smarty.const._MA_TADRSS_TITLE}>">
            </div>
            <div class="col-md-4">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="enable" id="enable_1" value="1" <{if $enable != "0"}>checked<{/if}>>
                <label class="form-check-label" for="enable_1"><{$smarty.const._YES}></label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="enable" id="enable_0" value="0" <{if $enable == "0"}>checked<{/if}>>
                <label class="form-check-label" for="enable_0"><{$smarty.const._NO}></label>
              </div>
            </div>
          </div>
          <input type="hidden" name="rss_sn" value="<{$rss_sn}>">
        <{/if}>

        <div class="form-group row">
          <div class="col-md-11">
            <input type="text" name="url" value="<{$rss_url}>" id="url" placeholder="<{$smarty.const._MA_TADRSS_URL}>" class="form-control">
          </div>
          <div class="col-md-1">
            <input type="hidden" name="op" value="<{$next_op}>">
            <button type="submit" class="btn btn-primary"><{$smarty.const._TAD_SAVE}></button>
          </div>
        </div>
      </form>

      <{if $all_data}>
        <table class="table table-striped table-hover">
          <tr>
            <th><{$smarty.const._MA_TADRSS_TITLE}></th>
            <th><{$smarty.const._MA_TADRSS_URL}></th>
            <th><{$smarty.const._MA_TADRSS_ENABLE}></th>
            <th><{$smarty.const._TAD_FUNCTION}></th>
          </tr>
          <tbody>
            <{foreach item=rss from=$all_data}>
              <tr>
                <td><{$rss.title}></td>
                <td><{$rss.url}></td>
                <td><a href="main.php?op=change_enable&rss_sn=<{$rss.rss_sn}>&enable=<{$rss.new_enable}>"><img src="../images/<{$rss.enable}>.gif"></a></td>
                <td>
                <a href="main.php?rss_sn=<{$rss.rss_sn}>" class="btn btn-sm btn-warning"><{$smarty.const._TAD_EDIT}></a>
                <a href="javascript:delete_tad_rss_func(<{$rss.rss_sn}>);" class="btn btn-sm btn-danger"><{$smarty.const._TAD_DEL}></a>
                </td>
              </tr>
            <{/foreach}>
          <tr>
          <td colspan=5 class="bar"><{$bar}></td></tr>
          </tbody>
        </table>
      <{/if}>
    </div>
  </div>
</div>