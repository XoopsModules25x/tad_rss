<{foreach item=rss_data from=$block.rss_data}>
    <div>
        <a href="<{$rss_data.link}>" rel="external" style="font-weight:bold;"><{$rss_data.title}></a>
        <ul class="vertical_menu">
            <{foreach item=rss from=$rss_data.content}>
                <li>
                <a href="<{$rss.link}>" rel="external">
                <{if $rss.date}>[<{$rss.date}>] <{/if}>
                <i class="fa fa-rss-square" aria-hidden="true"></i>
                <{$rss.title}>
                </a>
                </li>
            <{/foreach}>
        </ul>
    </div>
<{/foreach}>
<div class="text-right">
    <a href="<{$xoops_url}>/modules/tad_rss" class="badge badge-info">more...</a>
</div>
