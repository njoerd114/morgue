<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="model_label" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="model_label">Create</h3>
    <div class="alert">
      <?php
      $config = Configuration::get_configuration();
      if (array_key_exists('create_nag', $config)) {
        echo $config['create_nag']['nag_text'];
        if (array_key_exists('nag_link', $config['create_nag'])) {
          $nag_link = $config['create_nag']['nag_link'];
          $nag_link_text = $config['create_nag']['nag_link_text'];
          ?>
          <a href="<?php echo $nag_link;?>"><?php echo $nag_link_text;?></a>
        <?php
        }
      }
      ?>
    </div>
  </div>
  <div class="modal-body">
    <form class="form-horizontal" method="post" action="/events">
      <div class="control-group">
        <label class="control-label" for="title">Title</label>
        <div class="controls">
          <input type="text" placeholder="Title" id="title" name="title" class="input-xlarge">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="start_date">Start Time</label>
        <div class="controls controls-row">
          <input id="start_date" name="start_date" class="input-small datepicker" type="text">
          <input id="start_time" name="start_time" class="input-mini timeentry" type="text">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="end_date">End Time</label>
        <div class="controls controls-row">
          <input id="end_date" name="end_date" class="input-small datepicker" type="text">
          <input id="end_time" name="end_time" class="input-mini timeentry" type="text">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="detect_date">Detect Time</label>
        <div class="controls controls-row">
          <input id="detect_date" name="detect_date" class="input-small datepicker" type="text">
          <input id="detect_time" name="detect_time" class="input-mini timeentry" type="text">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="status_date">Status Time</label>
        <div class="controls controls-row">
          <div class=""><a href="#" id="add-status" role="button" class="btn">Add</a></div>
          <div class="hidden" id="event-status-container">
            <input id="status_date" name="status_date" class="input-small" type="text">
            <input id="status_time" name="status_time" class="input-mini" type="text">
            <a href="#" id="clear-status" role="button" class="btn">Clear</a>
          </div>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="timezone">Timezone</label>
        <div class="controls">
          <select id="timezone" name="timezone" class="input-large">
            <?php $timezones = DateTimeZone::listIdentifiers(); ?>
            <?php foreach ($timezones as $timezone) : ?>
              <option value="<?php echo $timezone ?>"><?php echo $timezone ?></option>
            <?php endforeach ?>
          </select>
        </div>
      </div>
      <div class="control-group">
      <label id="event-severity" class="control-label severity_levels" for="severity">Severity</label>
        <div class="controls">
          <select id="severity-select" name="severity" class="input-small" title="
          <?php
          if (isset($config['severity']) && isset($config['severity']['tooltip_title'])) {
            echo $config['severity']['tooltip_title'];
          } else {
            echo "Severity Levels";
          }
          ?>
          ">

          <?php
          $severity_levels = Postmortem::get_severity_levels();
          foreach ($severity_levels as $key => $severity_description) {
              $level = $key + 1;
              $severity_option = "<option value='{$level}' description='{$severity_description}'>{$level}</option>";
              echo $severity_option;
          } ?>
          </select>
        </div>
      </div>
        <?php
        if (array_key_exists('problem_type', $config)) {
            $problemTypeConfig  = $config['problem_type'];
            $problemTypeTitle   = $problemTypeConfig['title'];
            $problemTypeList    = $problemTypeConfig['types'];
            ?>
            <div class="control-group">
                <label class="control-label" for="problem_type"><?php echo $problemTypeTitle;?></label>
                <div class="controls">
                    <select id="problem_type" name="problem_type" class="input-large">
                        <?php
                        foreach ($problemTypeList as $problemType) {
                            ?>
                            <option value="<?php echo $problemType; ?>"><?php echo $problemType; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="control-group">
            <label class="control-label" for="subsystem">Subsystem</label>
            <div class="controls">
                <input type="text" placeholder="Subsystem" id="subsystem" name="subsystem" class="input-xlarge">
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="owner_team">Owner team</label>
            <div class="controls">
                <input type="text" placeholder="Owner Team" id="owner_team" name="owner_team" class="input-xlarge">
            </div>
        </div>
        <?php

        if (array_key_exists('impact_type', $config)) {
            $impactTypeConfig= $config['impact_type'];
            $impactTypeTitle= $impactTypeConfig['title'];
            $impactTypeList = $impactTypeConfig['types'];
            ?>
            <div class="control-group">
                <label class="control-label" for="impact_type"><?php echo $impactTypeTitle;?></label>
                <div class="controls">
                    <select id="impact_type" name="impact_type" class="input-large">
                        <?php
                        foreach ($impactTypeList as $impactType) {
                            ?>
                            <option value="<?php echo $impactType; ?>"><?php echo $impactType; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <?php
        }

        if (array_key_exists('incident_cause', $config)) {
            $incidentCauseConfig= $config['incident_cause'];
            $incidentCauseTitle = $incidentCauseConfig['title'];
            $incidentCauseList  = $incidentCauseConfig['causes'];
            ?>
            <div class="control-group">
                <label class="control-label" for="incident_cause"><?php echo $incidentCauseTitle;?></label>
                <div class="controls">
                    <select id="incident_cause" name="incident_cause" class="input-large">
                        <?php
                        foreach ($incidentCauseList as $incidentCause) {
                            ?>
                            <option value="<?php echo $incidentCause; ?>"><?php echo $incidentCause; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <?php
        }
        ?>
        <span id="titleinfo"> Title has to contain at least 3 characters </span>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary" type="submit" id="eventcreatebtn" >Create</button>
  </div>
  </form>
</div>
<script type="text/javascript" src="/assets/js/jquery.timeentry.min.js"></script>
<script type="text/javascript" src="/assets/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="/assets/js/bootstrap-modal.js"></script>
<script type="text/javascript" src="/assets/js/timehelpers.js"></script>
<script type="text/javascript" src="/assets/js/bootstrap-tooltip.js"></script>
<script type="text/javascript" src="/assets/js/bootstrap-popover.js"></script>
<script type="text/javascript" src="/assets/js/severity_tooltip.js"></script>
<script type="text/javascript">
$(document).ready(function () {

    $('.datepicker')
      .val($.datepicker.formatDate('mm/dd/yy', new Date()))
      .datepicker({
        format: 'mm/dd/yyyy'
      });

    $('.timeentry')
      .val(timeStringFromDate(new Date()))
      .timeEntry({
        spinnerImage: ''
      });

    $('#timezone').val('<?php echo getUserTimezone() ?>');
    $("#eventcreatebtn").attr("disabled", "true");
    $("#title").blur(function() {
        if ($("#title").attr("value").length > 2) {
            $("#eventcreatebtn").removeAttr("disabled");
        } else {
            $("#eventcreatebtn").attr("disabled", "true");
        }
    });

    $('#add-status').on('click', function() {
        var $fields = $('#event-status-container');
        if($fields.is(':hidden')) {
            $fields.prev().addClass('hidden');
            $fields.find('input[name=status_date]').val($.datepicker.formatDate('mm/dd/yy', new Date()));
            $fields.find('input[name=status_time]').val(timeStringFromDate(new Date()));
            $fields.removeClass('hidden');
        }
        return false;
    });
    $('#clear-status').on('click', function() {
        $fields = $('#event-status-container');
        $fields.addClass('hidden').prev().removeClass('hidden');
        $fields.find('input').val('');
    });
});

</script>
