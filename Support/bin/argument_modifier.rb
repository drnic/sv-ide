class ArgumentModifier
  attr_reader :document_lines, :line_num, :line_index, :original_line
  attr_reader :function_name, :argument_no, :line

  def initialize(document_lines, line_num, line_index)
    @document_lines, @line_num, @line_index = document_lines, line_num, (line_index-1)
    @original_line = line
    clean_document_lines
    parse
  end

  def argument?
    @is_argument
  end
  
  def line
    @line ||= document_lines[line_num-1]
  end
  
  def document
    lines = []
    lines = document_lines[0..line_num-2] if line_num > 1
    lines += [line]
    lines += document_lines[line_num..-1] if document_lines.length > line_num
    lines.join("\n") + "\n"
  end
  
  def arguments
    @arguments ||= begin
      argument_str = @before_arguments + @after_arguments
      argument_str.split(/,\s+/)
    end
  end
  
  def replace_argument(new_value)
    return self unless @arg_start_index && @arg_end_index
    value = ((argument_no == 1) ? '' : ' ') + new_value
    @line = original_line[0..@arg_start_index-1] + 
      value + original_line[@arg_end_index..-1]
    self
  end
  
  def replace_argument_with_string(new_string)
    replace_argument("'#{new_string}'")
  end
  
  protected
  def parse
    before, after = line[0..line_index-1], line[line_index..-1]
    @argument_no = -1
    return unless @is_argument = (before =~ /\b([\w_]+[$&#~@?](?:\{\}|\[\])?)\(([^)]*)$/)
    @function_name, @before_arguments = $1, $2
    @argument_no = @before_arguments.gsub(/[^,]/, '').length + 1
    return unless @is_argument = (after =~ /^([^)]*)\)/)
    @after_arguments = $1
    @arg_start_index, @arg_end_index = line_index, line_index
    @arg_start_index -= 1 until line[@arg_start_index-1..@arg_start_index-1] =~ /[(,]/
    @arg_end_index += 1 until line[@arg_end_index..@arg_end_index] =~ /[),]/
  end
  
  def clean_document_lines
    document_lines.each { |line| line.gsub!(/\n$/, '') }
  end
end

if $0 == __FILE__
  case ARGV.shift
  when "auto_complete"
    arg_auto = ArgumentModifier.new(STDIN.readlines, ENV["TM_LINE_NUMBER"].to_i, ENV["TM_LINE_INDEX"].to_i)
    arg_auto.replace_argument_with_string('XXX')
    print arg_auto.document
  when "replace"
    arg_auto = ArgumentModifier.new(STDIN.readlines, ENV["TM_LINE_NUMBER"].to_i, ENV["TM_LINE_INDEX"].to_i)
    arg_auto.replace_argument_with_string('YYY')
    print arg_auto.document
  end
end
