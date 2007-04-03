{strip}
<table>
	<tr>
		<th colspan="2">
			{$modInfo.name}
			<input type="hidden" name="modules[{$modInfo.module_id}][layout_area]" value="{$area}" />
		</th>
	</tr>
	<tr>
		<td style="text-align:right">{tr}Position{/tr}</td>
		<td>
			<input type="text" size="10" name="modules[{$modInfo.module_id}][pos]" value="{$modInfo.pos}" />
			{smartlink ititle="Up" ibiticon="icons/go-up" iforce="icon" page=layout move_module=up module_package=$module_package module_id=`$modInfo.module_id`}
			{smartlink ititle="Down" ibiticon="icons/go-down" iforce="icon" page=layout move_module=down module_package=$module_package module_id=`$modInfo.module_id`}
		</td>
	</tr>
	{if !$gBitThemes->isCustomModule( $modInfo.module_rsrc )}
		<tr>
			<td style="text-align:right">{tr}Title{/tr}</td>
			<td><input type="text" size="15" name="modules[{$modInfo.module_id}][title]" value="{$modInfo.title|escape}" /></td>
		</tr>
		<tr>
			<td style="text-align:right">{tr}Rows{/tr}</td>
			<td><input type="text" size="15" name="modules[{$modInfo.module_id}][module_rows]" value="{$modInfo.module_rows}" /></td>
		</tr>
		<tr>
			<td style="text-align:right">{tr}Parameters{/tr}</td>
			<td><input type="text" size="15" name="modules[{$modInfo.module_id}][params]" value="{$modInfo.params}" /></td>
		</tr>
	{/if}
	<tr>
		<td style="text-align:right">{tr}Cache Time{/tr}</td>
		<td><input type="text" size="15" name="modules[{$modInfo.module_id}][cache_time]" value="{$modInfo.cache_time}" /></td>
	</tr>
	<tr>
		<td style="text-align:right">{tr}Groups{/tr}</td>
		<td>
			<select multiple="multiple" size="3" name="modules[{$modInfo.module_id}][groups][]">
				{foreach from=$groups key=groupId item=group}
					{assign var=selected value=n}
					{foreach from=$modInfo.module_groups item=module_groups}
						{if $groupId == $module_groups}
							{assign var=selected value=y}
						{/if}
					{/foreach}
					<option value="{$groupId}" {if $selected eq 'y'}selected="selected"{/if}>{$group.group_name}</option>
				{/foreach}
			</select>
		</td>
	</tr>
	<tr>
		<td style="text-align:right"></td>
		<td>
			{if $colkey ne 'center'}
				{if $colkey == 'left'}
					{assign var=icon value=next}
					{assign var=move value=right}
				{elseif $colkey == 'right'}
					{assign var=icon value=previous}
					{assign var=move value=left}
				{/if}
				{smartlink ititle="Move module" ibiticon="icons/go-$icon" iforce="icon" page=layout move_module=$move module_package=$module_package module_id=$modInfo.module_id}
			{/if}
			&nbsp;&nbsp;
			{if $gBitThemes->isCustomModule( $modInfo.module_rsrc )}
				{smartlink ititle="Edit" ibiticon="icons/accessories-text-editor" iforce=icon page=custom_modules name=$modInfo.module_rsrc|regex_replace:"!.*\/!":"" action=edit}
				&nbsp;&nbsp;
			{/if}
			{smartlink ititle="Unassign" ibiticon="icons/edit-delete" iforce=icon ionclick="return confirm('Are you sure you want to remove `$modInfo.name`?');" page=layout move_module=unassign module_package=$module_package module_id=$modInfo.module_id}
		</td>
	</tr>
</table>
{/strip}