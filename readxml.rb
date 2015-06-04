# Read XML

require 'nokogiri'
require 'sequel'
require 'pp'

MASSAGE_TABLE = {
  'reference_number'    => nil,
  'local_authority'     => nil,
  'expected_delay'      => 'delay',
  'traffic_management'  => 'management',
  'centre_easting'      => 'easting',
  'centre_northing'     => 'northing',
  'status'              => nil,
  'published_date'      => nil
}

def massage(fields)
    MASSAGE_TABLE.each do |old_key, new_key|
      fields[new_key] = fields[old_key] unless new_key.nil?
      fields.delete old_key
    end
end

xml_file = ARGV[0] || "ha_roadworks_2015_06_01.xml"

unless File.exist? xml_file
  puts "Cannot open #{xml_file}"
  exit
end

puts "Reading #{xml_file}..."

doc   = Nokogiri::XML(File.open(xml_file))
works = doc.xpath('//ha_planned_works')

puts "Entries: #{works.count}"

# first = works.first.children
# fields = first.reduce({}) do |acc, node|
#   acc[node.name] = node.children.text if node.name != 'text'
#   acc
# end
# pp fields

# Open database and attach to 'roadworks' table
DB        = Sequel.postgres('roadworks')
roadworks = DB[:roadworks]

count = 0

works.each do |work|
  fields = work.children.reduce({}) do |acc, node|
    acc[node.name] = node.children.text if node.name != 'text'
    acc
  end

  massage(fields)
#   roadworks.insert(fields)

  count += 1
  print "#{count}... " if count % 100 == 0
end

puts "\nDone."
