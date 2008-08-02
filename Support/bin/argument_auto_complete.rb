class ArgumentAutoComplete
  attr_reader :document_lines, :line_num, :line_index, :original_line
  attr_reader :function_name, :argument_no, :line

  def initialize(document_lines, line_num, line_index)
    @document_lines, @line_num, @line_index = document_lines, line_num, line_index
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
  
  def replace_argument(new_value)
    value = ((argument_no == 1) ? '' : ' ') + new_value
    @line = original_line[0..@arg_start_index-1] + 
      value + original_line[@arg_end_index..-1]
    self
  end
  
  def replace_argument_with_string(new_string)
    replace_argument("'#{new_string}'")
    self
  end
  
  protected
  def parse
    before, after = line[0..line_index-1], line[line_index..-1]
    @argument_no = -1
    return unless @is_argument = (before =~ /\b([\w_]+[$&#~@?](?:\{\}|\[\])?)\(([^)]*)$/)
    @function_name, before_arguments = $1, $2
    @argument_no = before_arguments.split(/,/).length
    return unless @is_argument = (after =~ /^([^)]+)\)/)
    @arg_start_index, @arg_end_index = line_index, line_index
    until line[@arg_start_index-1..@arg_start_index-1] =~ /[(,]/
      @arg_start_index -= 1
    end
    until line[@arg_end_index..@arg_end_index] =~ /[),]/
      @arg_end_index += 1
    end
  end
  
  def clean_document_lines
    document_lines.each { |line| line.gsub!(/\n$/, '') }
  end
end

if $0 == __FILE__
  print ArgumentAutoComplete.new(STDIN.readlines, ENV["TM_LINE_NUMBER"].to_i, ENV["TM_LINE_INDEX"].to_i).replace_argument_with_string('XXX').document
end
