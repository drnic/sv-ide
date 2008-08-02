class ArgumentAutoComplete
  attr_reader :document_lines, :line_num, :line_index, :original_line
  attr_reader :function_name, :argument_no, :line

  def initialize(document_lines, line_num, line_index)
    @document_lines, @line_num, @line_index = document_lines, line_num, line_index
    @original_line = line
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
  
  def replace_argument(new_value)
    @line = original_line[0..@arg_start_index-1] + 
      new_value + original_line[@arg_end_index..-1]
  end
  
  def replace_argument_with_string(new_string)
    replace_argument("'#{new_string}'")
  end
  
  protected
  def parse
    before, after = line[0..line_index-1], line[line_index..-1]
    @argument_no = -1
    return unless @is_argument = (before =~ /\b([\w_]+[$&#~@?](?:\{\}|\[\])?)\(([^)]*)$/)
    @function_name, before_arguments = $1, $2
    @argument_no = (commas = before_arguments.match(/,/)) ? commas.length : 1
    return unless @is_argument = (after =~ /^([^)]+)\)/)
    @arg_start_index, @arg_end_index = line_index, line_index
    until line[@arg_start_index-1..@arg_start_index-1] =~ /[(,]/
      @arg_start_index -= 1
    end
    until line[@arg_end_index..@arg_end_index] =~ /[),]/
      @arg_end_index += 1
    end
  end
end

if $0 == __FILE__
  print ArgumentAutoComplete.new(STDIN.readlines, ENV["TM_LINE_NUMBER"], ENV["TM_LINE_INDEX"]).replace_argument_with_string('XXX').document
end
