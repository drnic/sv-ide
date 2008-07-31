class FunctionDefnParser
  def initialize(document_lines)
    @lines = document_lines
  end
  
  def parameters
    %w[c_ChargeMethod&]
  end
end