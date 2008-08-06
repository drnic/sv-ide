require File.dirname(__FILE__) + '/function_defn_parser'
class FunctionDefn
  attr_reader :name, :signature, :parameters, :interface
  def initialize(filepath)
    @filepath   = filepath
    parser      = FunctionDefnParser.new(File.readlines(File.join(self.class.dir, filepath)))
    @name       = parser.name
    @parameters = parser.parameters
    @signature  = parser.signature
    filepath =~ /-(\d+)\.epm$/
    @interface  = $1.to_i if $1
  end
  
  # Returns FunctionDefn for function with +name+ (e.g. ReferenceCodeByLabel&)
  # The result is always a hash with the key a number 1+ representing its interface number
  # Normally there is only one interface, so the result will be {1 => <FunctionDefn name=ReferenceCodeByLabel&>}
  def self.find_by_name(function_name)
    filename_prefix = function_name_to_filename_prefix(function_name)
    cmd = %Q{cd #{dir} && find * | grep "\/#{filename_prefix}.*epm$"}
    epm_files = `#{cmd}`.split("\n")
    epm_files.inject({}) do |interfaces, filepath|
      filepath =~ /-(\d+)\.epm$/
      interfaces[$1.to_i] = self.new(filepath)
      interfaces
    end
  end
  
  # Returns a list of function names that start with +partial+
  # Note, there may be 1+ interface versions for each result
  def self.find_names_by_partial(partial)
    cmd = %Q{cd #{dir} && find * | sed -e "s/.*\\///" | grep "epm$" | grep "^#{partial}"}
    functions = `#{cmd}`.split("\n").map { |function| filename_to_function_name function }.uniq
  end
  
  def self.filename_to_function_name(filename)
    name, type, interface_no = filename.gsub('.epm', '').split('-')
    "#{name}#{typecode_by_name[type]}"
  end
  
  def self.function_name_to_filename_prefix(function_name)
    name, typecode = function_name.match(/([\w_.]+)([$&#~@?]?(?:\{\}|\[\])?)/)[1..2]
    "#{name}-#{typename_by_code[typecode]}"
  end
  
  def self.typecode_by_name
    @@typecode_by_name ||= {
      'blob' => '@',
      'date' => '~',
      'string' => '$',
      'integer' => '&',
      'real' => '#',
      'unknown' => '?',

      'blobarray' => '@[]',
      'datearray' => '~[]',
      'stringarray' => '$[]',
      'integerarray' => '&[]',
      'realarray' => '#[]',
      'unknownarray' => '?[]',

      'datehash' => '~{}',
      'stringhash' => '${}',
      'integerhash' => '&{}',
      'realhash' => '#{}',
      'unknownhash' => '?{}',
      'blobhash' => '@{}',
      }
  end
  
  def self.typename_by_code
    @@typename_by_code ||= Hash[*typecode_by_name.to_a.flatten.reverse]
  end
  
  def self.dir
    Environment.cache_dir
  end
end
