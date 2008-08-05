require File.dirname(__FILE__) + "/test_helper"


class TestSqlqueryReformat < Test::Unit::TestCase
  context "multiline sql" do
    setup do
      @initially = <<-EPM
      var lRows?[] := SQLQuery?[]('SELECT tq.schedule_id   ' +
                  '  FROM bill_run br, task_queue tq, schedule s ' +
                  ' WHERE bill_run_id = :br_id ' +
                  '   AND br.creation_task_queue_id = tq.task_queue_id ' +
                  '   AND tq.schedule_id = s.schedule_id ' +
                  '   AND schedule_name like \'%T2 Debit Memo Bill Run%\'',['br_id'],[c_billRunId&]);
      EPM
      @expected = <<-EPM
      var lRows?[] := SQLQuery?[]('SELECT tq.schedule_id ' +
                      '  FROM bill_run br, task_queue tq, schedule s ' +
                      ' WHERE bill_run_id               = :br_id ' +
                      '   AND br.creation_task_queue_id = tq.task_queue_id ' +
                      '   AND tq.schedule_id            = s.schedule_id ' +
                      '   AND schedule_name like \'%T2 Debit Memo Bill Run%\'',
                      ['br_id'],
                      [c_billRunId&]);
      EPM
    end

    should_eventually "convert to expected"
  end
  
  context "single-line sql" do
    setup do
      @initially = <<-EPM
      var lRows?[] := SQLQuery?[]('SELECT tq.schedule_id FROM bill_run br, task_queue tq, schedule s WHERE bill_run_id = :br_id AND br.creation_task_queue_id = tq.task_queue_id AND tq.schedule_id = s.schedule_id AND schedule_name like \'%T2 Debit Memo Bill Run%\'',['br_id'],[c_billRunId&]);
      EPM
      @expected = <<-EPM
      var lRows?[] := SQLQuery?[]('SELECT tq.schedule_id ' +
                      '  FROM bill_run br, task_queue tq, schedule s ' +
                      ' WHERE bill_run_id               = :br_id ' +
                      '   AND br.creation_task_queue_id = tq.task_queue_id ' +
                      '   AND tq.schedule_id            = s.schedule_id ' +
                      '   AND schedule_name like \'%T2 Debit Memo Bill Run%\'',
                      ['br_id'],
                      [c_billRunId&]);
      EPM
    end

    should_eventually "convert to expected"
  end
  
  context "non-SQLQuery block" do
    setup do
      @initially = "var lSomeVar& := 'SELECT * from FUNCTION_DEFN_HISTORY';"
    end

    should_eventually "do nothing"
  end
  
end