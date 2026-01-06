<?php
/**
 * This file is part of the Rodas\System library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package Rodas\System
 * @copyright 2026 Marcos Porto <php@marcospor.to>
 * @license https://opensource.org/license/mit The MIT License
 * @link https://marcospor.to/repositories/system
 */

declare(strict_types=1);

namespace Rodas\System;

/**
 * List of Error Codes
 *
 * Based in .Net/Win32 Error Codes
 */
class HResults {
    private function __construct() {
      // Singleton pattern
    }

    // General errors
    public const S_OK                       = 0x00000000; // Successful operation
    public const S_FALSE                    = 0x00000001; // Successful operation without significant results
    public const E_FAIL                     = 0x80004005; // Unspecified error
    public const E_ACCESSDENIED             = 0x80070005; // Access denied
    public const E_OUTOFMEMORY              = 0x8007000E; // Insufficient memory
    public const E_INVALIDARG               = 0x80070057; // Invalid argument
    public const E_POINTER                  = 0x80004003; // Null pointer
    public const E_NOTIMPL                  = 0x80004001; // Method not implemented
    public const E_ABORT                    = 0x80004004; // Operation aborted
    public const E_UNEXPECTED               = 0x8000FFFF; // Unexpected error
    public const E_HANDLE                   = 0x80070006; // Invalid handle
    public const E_NOINTERFACE              = 0x80004002; // Requested interface not supported
    public const E_NOTSET                   = 0x80070490; // Value not set
    public const E_PENDING                  = 0x8000000A; // Data necessary to complete operation not yet available
    public const E_BOUNDS                   = 0x8000000B; // Operation attempted to access data outside valid range
    public const E_CHANGED_STATE            = 0x8000000C; // Operation cannot be performed in current state
    public const E_ILLEGAL_STATE_CHANGE     = 0x8000000D; // Operation cannot be performed in current state
    public const E_ILLEGAL_METHOD_CALL      = 0x8000000E; // Method call not allowed in current state

    // File and directory related errors
    public const COR_E_FILENOTFOUND         = 0x80070002; // File not found
    public const COR_E_DIRECTORYNOTFOUND    = 0x80070003; // Directory not found
    public const COR_E_PATHTOOLONG          = 0x800700CE; // Path too long
    public const COR_E_UNAUTHORIZEDACCESS   = 0x80070005; // Unauthorized access
    public const COR_E_PATHFORMAT           = 0x80131537; // Invalid path format
    public const COR_E_SECURITY             = 0x8013150A; // Security error
    public const COR_E_BADIMAGEFORMAT       = 0x8007000B; // Bad image format
    public const COR_E_ASSEMBLYEXPECTED     = 0x80131018; // Assembly expected
    public const COR_E_MISSINGMANIFESTRESOURCE = 0x80131532; // Missing manifest resource

    // I/O operation errors
    public const COR_E_IO                   = 0x80131620; // Input/output error
    public const COR_E_FILELOAD             = 0x80131621; // File load error
    public const COR_E_ENDOFSTREAM          = 0x80070026; // Unexpected end of stream
    public const COR_E_OBJECTDISPOSED       = 0x80131622; // Object disposed
    public const COR_E_DRIVENOTFOUND        = 0x80070015; // Drive not found
    public const COR_E_SHARING              = 0x80070020; // Sharing violation
    public const COR_E_LOCKVIOLATION        = 0x80070021; // Lock violation

    // Argument related errors
    public const COR_E_ARGUMENT             = 0x80070057; // Invalid argument
    public const COR_E_ARGUMENTOUTOFRANGE   = 0x80131502; // Argument out of allowed range
    public const COR_E_ARGUMENTNULL         = 0x80004003; // Null argument
    public const COR_E_INVALIDOPERATION     = 0x80131509; // Invalid operation
    public const COR_E_NOTSUPPORTED         = 0x80131515; // Operation not supported
    public const COR_E_DUPLICATEWAITOBJECT  = 0x80131529; // Duplicate wait object
    public const COR_E_SEMAPHOREFULL        = 0x8013152B; // Semaphore full
    public const COR_E_WAITHANDLECANNOTBEOPENED = 0x8013152C; // Wait handle cannot be opened
    public const COR_E_ABANDONEDMUTEX       = 0x8013152D; // Abandoned mutex

    // Threading and synchronization errors
    public const COR_E_SYNCHRONIZATIONLOCK  = 0x80131518; // Synchronization lock error
    public const COR_E_THREADINTERRUPTED    = 0x80131519; // Thread interrupted
    public const COR_E_THREADABORTED        = 0x80131530; // Thread aborted
    public const COR_E_THREADSTATE          = 0x80131520; // Invalid thread state
    public const COR_E_THREADSTART          = 0x80131525; // Thread start error
    public const COR_E_TIMEOUT              = 0x80131505; // Operation timed out

    // Collection and array errors
    public const COR_E_INDEXOUTOFRANGE      = 0x80131508; // Index out of range
    public const COR_E_RANK                 = 0x80131517; // Array rank error
    public const COR_E_ARRAYLIST            = 0x80131503; // ArrayList error
    public const COR_E_KEYNOTFOUND          = 0x80131577; // Key not found
    public const COR_E_INVALIDCAST          = 0x80004002; // Invalid cast
    public const COR_E_OVERFLOW             = 0x80131516; // Arithmetic overflow
    public const COR_E_DIVIDEBYZERO         = 0x80020012; // Division by zero

    // Format and parsing errors
    public const COR_E_FORMAT               = 0x80131537; // Format error
    public const COR_E_FORMATEXCEPTION      = 0x80131537; // Format exception
    public const COR_E_INVALIDPROGRAM       = 0x8013153A; // Invalid program
    public const COR_E_INVALIDFILTERCRITERIA = 0x80131601; // Invalid filter criteria
    public const COR_E_MISSINGFIELD         = 0x80131511; // Missing field
    public const COR_E_MISSINGMETHOD        = 0x80131513; // Missing method
    public const COR_E_MISSINGMEMBER        = 0x80131512; // Missing member

    // Network and communication errors
    public const COR_E_NETWORK              = 0x80131040; // Network error
    public const COR_E_REMOTING             = 0x8013150B; // Remoting error
    public const COR_E_SERVER               = 0x8013150E; // Server error
    public const COR_E_SERIALIZATION        = 0x8013150C; // Serialization error
    public const COR_E_SOCKET               = 0x80131500; // Socket error

    // Reflection and metadata errors
    public const COR_E_REFLECTION           = 0x80131540; // Reflection error
    public const COR_E_REFLECTIONTYPELOAD   = 0x80131602; // Reflection type load error
    public const COR_E_CUSTOMATTRIBUTEFORMAT = 0x80131605; // Custom attribute format error
    public const COR_E_INVALIDCOMOBJECT     = 0x80131527; // Invalid COM object
    public const COR_E_MEMBERACCESS         = 0x8013151A; // Member access error
    public const COR_E_METHODACCESS         = 0x80131510; // Method access error
    public const COR_E_FIELDACCESS          = 0x80131507; // Field access error
    public const COR_E_TYPEACCESS           = 0x80131543; // Type access error

    // Security and cryptography errors
    public const COR_E_VERIFICATION         = 0x8013150D; // Verification error
    public const COR_E_CRYPTOGRAPHY         = 0x80131430; // Cryptography error
    public const COR_E_POLICY               = 0x80131416; // Policy error
    public const COR_E_EVIDENCE             = 0x80131417; // Evidence error

    // COM and interop errors
    public const COR_E_COMEMULATE           = 0x80131535; // COM emulation error
    public const COR_E_INTEROPSERVICES      = 0x80131623; // Interop services error
    public const COR_E_MARSHALDIRECTIVE     = 0x80131535; // Marshal directive error
    public const COR_E_SAFEARRAYRANKMISMATCH = 0x80131538; // SafeArray rank mismatch
    public const COR_E_SAFEARRAYTYPEMISMATCH = 0x80131533; // SafeArray type mismatch

    // Configuration and application errors
    public const COR_E_CONFIGURATION        = 0x80131902; // Configuration error
    public const COR_E_CONFIGURATIONPOLICY  = 0x80131902; // Configuration policy error
    public const COR_E_CANNOTUNLOADAPPDOMAIN = 0x80131015; // Cannot unload app domain
    public const COR_E_APPDOMAINUNLOADED    = 0x80131014; // App domain unloaded
    public const COR_E_APPLICATION          = 0x80131600; // Application error

    // DLL and assembly loading errors
    public const COR_E_DLLNOTFOUND          = 0x80131577; // DLL not found
    public const COR_E_ENTRYPOINTNOTFOUND   = 0x80131523; // Entry point not found
    public const COR_E_TYPELOAD             = 0x80131522; // Type load error
    public const COR_E_TYPEINITIALIZATION   = 0x80131534; // Type initialization error
    public const COR_E_FIXUPSINEXE          = 0x80131019; // Fixups in executable
}
